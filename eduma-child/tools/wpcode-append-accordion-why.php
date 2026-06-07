
// Acordeón «¿Por qué elegirnos?» — textos SEO (home). Acentos como entidades HTML.
if ( ! function_exists( 'infosystem_replace_home_why_accordion' ) ) {
	function infosystem_replace_home_why_accordion( $html, $cursos, $como ) {
		$contacto = esc_url( home_url( '/contacto/' ) );
		$panels   = array(
			'920e3b8' => sprintf(
				'Si trabajas en activo en <strong>Castilla-La Mancha</strong>, puedes acceder a <strong>cursos gratuitos subvencionados para trabajadores</strong> (SEPE y Junta), compatibles con tu jornada laboral. Formaci&oacute;n <strong>100&nbsp;%% online</strong>, sin coste de matr&iacute;cula y con certificado al finalizar: digitalizaci&oacute;n, ofim&aacute;tica, idiomas, PRL y competencias transversales. <a href="%1$s">Consulta el cat&aacute;logo de cursos</a> o <a href="%2$s">descubre c&oacute;mo inscribirte paso a paso</a>.',
				$cursos,
				$como
			),
			'95852de' => sprintf(
				'En situaci&oacute;n de <strong>desempleo</strong>, la formaci&oacute;n programada para el empleo te permite reforzar tu curr&iacute;culum sin pagar matr&iacute;cula. Ofrecemos cientos de <strong>cursos subvencionados online en Castilla-La Mancha</strong>: orientaci&oacute;n laboral, ofim&aacute;tica en la nube, atenci&oacute;n al cliente, log&iacute;stica y sectores con demanda actual. Te orientamos en requisitos, plazas y documentaci&oacute;n ante el SEPE. <a href="%1$s">Ver todos los cursos gratuitos</a>.',
				$cursos
			),
			'2d48fb3' => sprintf(
				'Tu empresa puede <strong>bonificar la formaci&oacute;n de la plantilla</strong> mediante el cr&eacute;dito de formaci&oacute;n (antiguo Fundae): formaci&oacute;n subvencionada sin coste para el empleado y con retorno en productividad. En Infosystem impartimos acciones en digitalizaci&oacute;n, prevenci&oacute;n de riesgos, idiomas y liderazgo en toda <strong>Castilla-La Mancha</strong>. Gestionamos documentaci&oacute;n e impartici&oacute;n online. <a href="%1$s">Solicita informaci&oacute;n para empresas</a>.',
				$contacto
			),
			'189de56' => sprintf(
				'Cada curso cuenta con <strong>tutores especializados</strong> en su materia: no es solo v&iacute;deo sin acompa&ntilde;amiento. Resolvemos dudas, revisamos ejercicios y te guiamos hasta la evaluaci&oacute;n final con contenidos actualizados y enfoque pr&aacute;ctico para el empleo. Centro de referencia en formaci&oacute;n para el empleo en la regi&oacute;n. <a href="%1$s">Explora nuestras &aacute;reas formativas</a>.',
				$cursos
			),
		);
		foreach ( $panels as $id => $copy ) {
			$html = preg_replace(
				'/(<p[^>]*data-interaction-id="' . preg_quote( $id, '/' ) . '"[^>]*>)[\s\S]*?(<\/p>)/',
				'$1' . $copy . '$2',
				$html,
				1
			);
		}
		$html = str_replace(
			'Elige el plan que mejor se adapte a tu perfil y empieza hoy mismo.',
			'M&aacute;s de 500 cursos subvencionados en Castilla-La Mancha. Elige tu perfil y empieza hoy sin coste de matr&iacute;cula.',
			$html
		);
		$html = str_replace(
			'M&Atilde;&iexcl;s de 500 cursos subvencionados en Castilla-La Mancha. Elige tu perfil y empieza hoy sin coste de matr&Atilde;&shy;cula.',
			'M&aacute;s de 500 cursos subvencionados en Castilla-La Mancha. Elige tu perfil y empieza hoy sin coste de matr&iacute;cula.',
			$html
		);
		$fallback = sprintf(
			'Formaci&oacute;n subvencionada online en Castilla-La Mancha con Infosystem: inscripci&oacute;n flexible y certificado al finalizar. <a href="%1$s">Ver cursos gratuitos</a>.',
			$cursos
		);
		return str_replace( 'Inscr&iacute;bete cuando quieras, formaci&oacute;n a tu ritmo.', $fallback, $html );
	}
}
