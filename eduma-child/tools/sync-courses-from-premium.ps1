# Sync CLM courses from cursospremiumonline.es to Infosystem site.
# Usage: powershell -File sync-courses-from-premium.ps1

$ErrorActionPreference = 'Stop'
$base = 'https://friendly-sutherland.5-175-47-192.plesk.page'
$user = 'CursosPremium'
$pass = '@H5Nx*dibd1z5gPw'
$pair = "${user}:${pass}"
$authB64 = [Convert]::ToBase64String([Text.Encoding]::ASCII.GetBytes($pair))
$headers = @{ Authorization = "Basic $authB64" }
$catId = 89

function Get-RemoteJson($url) {
	(Invoke-RestMethod -Uri $url -UseBasicParsing)
}

function Invoke-WpJson($method, $path, $body) {
	$uri = "$base/wp-json/wp/v2$path"
	$params = @{
		Uri     = $uri
		Method  = $method
		Headers = $headers
	}
	if ($null -ne $body) {
		$params.Body        = ($body | ConvertTo-Json -Depth 30 -Compress)
		$params.ContentType = 'application/json; charset=utf-8'
	}
	Invoke-RestMethod @params
}

function Upload-MediaFromUrl($imageUrl) {
	$tmp = Join-Path $env:TEMP ([IO.Path]::GetFileName($imageUrl))
	Invoke-WebRequest -Uri $imageUrl -OutFile $tmp -UseBasicParsing
	$boundary = [System.Guid]::NewGuid().ToString()
	$fileBytes = [System.IO.File]::ReadAllBytes($tmp)
	$enc = [System.Text.Encoding]::UTF8
	$lf = "`r`n"
	$header = $enc.GetBytes(
		"--$boundary$lf" +
		"Content-Disposition: form-data; name=`"file`"; filename=`"$([IO.Path]::GetFileName($tmp))`"$lf" +
		"Content-Type: application/octet-stream$lf$lf"
	)
	$footer = $enc.GetBytes("$lf--$boundary--$lf")
	$body = New-Object byte[] ($header.Length + $fileBytes.Length + $footer.Length)
	[Array]::Copy($header, 0, $body, 0, $header.Length)
	[Array]::Copy($fileBytes, 0, $body, $header.Length, $fileBytes.Length)
	[Array]::Copy($footer, 0, $body, $header.Length + $fileBytes.Length, $footer.Length)
	$mediaHeaders = @{
		Authorization = "Basic $authB64"
		'Content-Type' = "multipart/form-data; boundary=$boundary"
	}
	$result = Invoke-RestMethod -Uri "$base/wp-json/wp/v2/media" -Method Post -Headers $mediaHeaders -Body $body
	Remove-Item $tmp -Force -ErrorAction SilentlyContinue
	return $result.id
}

function Ensure-Tag($name) {
	$slug = ($name.ToLower() -replace 'á','a' -replace 'é','e' -replace 'í','i' -replace 'ó','o' -replace 'ú','u' -replace 'ñ','n' -replace '\s+','-')
	$found = @(Invoke-WpJson Get "/product_tag?slug=$slug")
	if ($found.Count -gt 0) { return $found[0].id }
	(Invoke-WpJson Post '/product_tag' @{ name = $name; slug = $slug }).id
}

function Strip-Html($html) {
	if (-not $html) { return '' }
	( $html -replace '<[^>]+>', '' -replace '\s+', ' ' ).Trim()
}

function Copy-Product($sourceSlug) {
	$src = @(Get-RemoteJson "https://cursospremiumonline.es/wp-json/wp/v2/product?slug=$sourceSlug&_embed=wp:featuredmedia,wp:term")[0]
	if (-not $src) { throw "Source not found: $sourceSlug" }

	$media = $src._embedded.'wp:featuredmedia'[0]
	$featId = 0
	if ($media.source_url) {
		$featId = Upload-MediaFromUrl $media.source_url
		Write-Host "Uploaded image for $sourceSlug -> media $featId"
	}

	$tagIds = @()
	foreach ($termGroup in $src._embedded.wpterm) {
		foreach ($t in $termGroup) {
			if ($t.taxonomy -eq 'product_tag') {
				$tagIds += (Ensure-Tag $t.name)
			}
		}
	}

	$title = Strip-Html $src.title.rendered
	$excerpt = Strip-Html $src.excerpt.rendered
	$content = $src.content.rendered

	$existing = @(Invoke-WpJson Get "/product?slug=$sourceSlug")
	if ($existing.Count -eq 0 -and $sourceSlug -like '*ofimatica*') {
		$legacy = @(Invoke-WpJson Get '/product?slug=curso-ofimatica-en-la-nube-con-google-drive-clm')
		if ($legacy.Count -gt 0) { $existing = $legacy }
	}

	$payload = @{
		title             = $title
		slug              = $sourceSlug
		content           = $content
		excerpt           = $excerpt
		featured_media    = $featId
		product_cat       = @($catId)
		product_tag       = $tagIds
		regular_price     = '0'
		status            = 'publish'
	}

	if ($existing.Count -gt 0) {
		$id = $existing[0].id
		Invoke-WpJson Put "/product/$id" $payload | Out-Null
		Write-Host "Updated product $id ($sourceSlug)"
		if ($sourceSlug -like '*ofimatica*' -and $existing[0].slug -ne $sourceSlug) {
			Invoke-WpJson Put "/product/$id" @{ slug = $sourceSlug } | Out-Null
		}
		return $id
	}

	$payload.type = 'simple'
	$id = (Invoke-WpJson Post '/product' $payload).id
	Write-Host "Created product $id ($sourceSlug)"
	return $id
}

Write-Host 'Updating category...'
Invoke-WpJson Put "/product_cat/$catId" @{
	name        = 'Cursos Castilla la Mancha'
	description = 'Cursos gratuitos subvencionados en Castilla-La Mancha.'
} | Out-Null

Copy-Product 'curso-de-gestion-de-negocios-online-2-0-clm' | Out-Null
Copy-Product 'curso-ofimatica-en-la-nube-con-google-drive' | Out-Null

# Remove legacy ofimatica slug product if duplicate exists
$legacy = @(Invoke-WpJson Get '/product?slug=curso-ofimatica-en-la-nube-con-google-drive-clm')
$good = @(Invoke-WpJson Get '/product?slug=curso-ofimatica-en-la-nube-con-google-drive')
if ($legacy.Count -gt 0 -and $good.Count -gt 0 -and $legacy[0].id -ne $good[0].id) {
	Invoke-WpJson Delete "/product/$($legacy[0].id)?force=true" | Out-Null
	Write-Host "Removed duplicate legacy ofimatica product"
}

Write-Host 'Deactivating LearnPress plugins...'
$plugins = Invoke-RestMethod -Uri "$base/wp-json/wp/v2/plugins?per_page=100" -Headers $headers
foreach ($pl in $plugins) {
	if (($pl.plugin -match 'learnpress|learn-press') -or (($pl.name + $pl.plugin) -match 'LearnPress')) {
		if ($pl.status -eq 'active') {
			Invoke-RestMethod -Uri "$base/wp-json/wp/v2/plugins/$([uri]::EscapeDataString($pl.plugin))" -Method Post -Headers $headers -Body (@{ status = 'inactive' } | ConvertTo-Json) -ContentType 'application/json' | Out-Null
			Write-Host "Deactivated: $($pl.name)"
		}
	}
}

Write-Host 'Done.'
