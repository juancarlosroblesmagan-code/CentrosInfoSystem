# 06 · Página de Preguntas Frecuentes (FAQ)

URL: `/preguntas-frecuentes/` · ID `16729` · creada el 26/05/2026.

Contenido íntegro guardado en [`content/faq-content.html`](../content/faq-content.html).

---

## Objetivo SEO

Capturar tráfico informativo de búsquedas tipo:

- "qué es un curso subvencionado"
- "cómo apuntarse a curso SEPE"
- "requisitos certificado profesionalidad"
- "diferencia SEPE y FUNDAE"
- "FUNDAE bonificación empresas"
- "trabajadores en activo formación gratuita"

…y posicionar **rich snippets de FAQ** en Google (cuando se vuelvan a activar para sitios no muy autoritativos).

---

## Estructura de contenido

28 preguntas en 5 secciones temáticas (H2):

### Sección 1 · Cursos subvencionados SEPE y JCCM: información general

1. ¿Qué son los cursos subvencionados por el SEPE y la Junta de Castilla-La Mancha?
2. ¿Cuánto cuestan los cursos subvencionados de Infosystem?
3. ¿Quién puede acceder a los cursos subvencionados en Castilla-La Mancha?
4. ¿Qué requisitos debo cumplir para inscribirme en un curso gratuito?
5. ¿Cómo me inscribo en un curso subvencionado de Infosystem?

### Sección 2 · Modalidades, certificaciones y reconocimiento

6. ¿Son cursos online o presenciales?
7. ¿Los cursos son oficiales y entregan certificado?
8. ¿Qué es un certificado de profesionalidad?
9. ¿Cuál es la diferencia entre un certificado de profesionalidad y un diploma de aprovechamiento?
10. ¿Cuánto duran los cursos subvencionados?

### Sección 3 · Beneficios para trabajadores y desempleados

11. ¿Qué beneficios tiene formarme si estoy desempleado?
12. ¿Qué beneficios tiene formarme si trabajo en activo?
13. ¿Necesito pedir permiso a mi empresa si soy trabajador en activo?
14. ¿Pierdo el subsidio de desempleo si hago un curso del SEPE?
15. ¿Cuántos cursos puedo hacer al año?

### Sección 4 · FUNDAE y empresas

16. ¿Qué es FUNDAE y para qué sirve?
17. ¿Cómo bonifica mi empresa la formación a través de FUNDAE?
18. ¿Cuánto crédito FUNDAE tengo disponible?
19. ¿Infosystem gestiona el papeleo FUNDAE por mí?
20. ¿Qué cursos puedo bonificar con FUNDAE en CLM?

### Sección 5 · Sobre Infosystem y nuestros centros

21. ¿Dónde está Infosystem? ¿Tenéis centros físicos?
22. ¿Puedo hacer el curso desde otro punto de Castilla-La Mancha?
23. ¿Tengo un tutor que me ayude durante el curso?
24. ¿Y si tengo poca soltura con el ordenador?
25. ¿Cómo funciona la plataforma online?
26. ¿Qué pasa si no puedo terminar el curso?
27. ¿Puedo trabajar como formador/a en Infosystem?
28. ¿Cómo me pongo en contacto con vosotros?

---

## Schema FAQPage

El snippet WPCode escanea el contenido renderizado de la página, busca pares `<h3>pregunta</h3> + texto inmediatamente siguiente`, y emite un JSON-LD `FAQPage` con todas las preguntas/respuestas como `mainEntity`.

Funciona porque la página usa la estructura de bloques de Gutenberg `wp:heading {"level":3}` + `wp:paragraph`. **Si se rediseña con acordeones de Elementor, hay que revisar el regex** del snippet.

---

## SEO Rank Math (campos)

| Campo | Valor |
|-------|-------|
| Title | `Preguntas frecuentes - Cursos subvencionados Castilla-La Mancha | Infosystem` |
| Description | Resuelve todas tus dudas sobre los cursos gratuitos subvencionados por el SEPE y la Junta de Castilla-La Mancha en Infosystem - Centro de Educación Polivalente. |
| Focus keyword | `preguntas frecuentes cursos subvencionados` |

---

## Mantenimiento

- **Añadir una FAQ nueva**: editar la página en WordPress, añadir un bloque H3 (pregunta) seguido de un bloque párrafo (respuesta) dentro de la sección H2 correspondiente. El schema se regenera automáticamente.
- **Reordenar secciones**: respetar la estructura H2 (secciones) / H3 (preguntas) / párrafo (respuesta).
- **Vincular productos/posts**: usar enlaces internos con anchor text descriptivo.
