import requests
import re
import html

def purge():
    session = requests.Session()
    session.headers.update({
        'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
    })
    
    login_url = 'https://centrosinfosystem.com/wp-login.php'
    login_data = {
        'log': 'InfoSystem',
        'pwd': 't@C8im%@a87FSBADu$!Lj#s@',
        'wp-submit': 'Acceder',
        'redirect_to': 'https://centrosinfosystem.com/wp-admin/',
        'testcookie': '1'
    }
    session.post(login_url, data=login_data, timeout=25)
    
    # 1. Access admin bar on dashboard
    dash = session.get('https://centrosinfosystem.com/wp-admin/', timeout=25)
    raw_purges = re.findall(r'href=["\']([^"\']*action=purge_cache[^"\']*)["\']', dash.text)
    print("Found admin bar purge links:", len(raw_purges))
    
    for p in raw_purges:
        clean_url = html.unescape(p)
        print("Triggering purge:", clean_url)
        res = session.get(clean_url, timeout=25, allow_redirects=True)
        print("Result:", res.status_code, res.url)
        
    # 2. Access options-general.php?page=wprocket
    wprocket = session.get('https://centrosinfosystem.com/wp-admin/options-general.php?page=wprocket', timeout=25)
    rocket_purges = re.findall(r'href=["\']([^"\']*action=purge_cache[^"\']*)["\']', wprocket.text)
    print("Found WP Rocket settings purge links:", len(rocket_purges))
    for p in rocket_purges:
        clean_url = html.unescape(p)
        print("Triggering rocket purge:", clean_url)
        res = session.get(clean_url, timeout=25, allow_redirects=True)
        print("Result:", res.status_code, res.url)

    # 3. Check public homepage
    pub_session = requests.Session()
    pub_session.headers.update({
        'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
        'Cache-Control': 'no-cache',
        'Pragma': 'no-cache'
    })
    
    pub_res = pub_session.get('https://centrosinfosystem.com/', timeout=25)
    has_widget = 'infosystem-wa-widget' in pub_res.text
    print("\n--- PUBLIC HOMEPAGE VERIFICATION ---")
    print(f"URL: https://centrosinfosystem.com/")
    print(f"Status: {pub_res.status_code}")
    print(f"Has WhatsApp Widget in HTML: {has_widget}")
    if has_widget:
        print("SUCCESS! The WhatsApp widget is live and visible on public production without any query parameter!")
    else:
        print("Notice: Still cached. Length:", len(pub_res.text))

if __name__ == '__main__':
    purge()
