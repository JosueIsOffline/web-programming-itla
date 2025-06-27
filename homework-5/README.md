# 🌐 Portal Web Dinámico con 10 APIs en PHP

> Proyecto web desarrollado en PHP, utilizando 10 APIs externas para mostrar información de forma visual, interactiva y funcional. ¡Explora datos curiosos y útiles desde un solo lugar!

---

## 🎯 Objetivo

Desarrollar un **portal web dinámico en PHP** que integre 10 APIs distintas, cada una en su propia sección, con una experiencia de usuario fluida, visualmente atractiva y con buen manejo de errores.

---

## 🎨 Diseño y Tecnologías

- **Framework CSS utilizado:** _[Bootstrap 5 / Tailwind / Bulma]_  
- **Motivo de elección:** [Explica brevemente por qué escogiste ese framework, ej. facilidad de uso, componentes listos, personalización, etc.]

---

## 🗂️ Estructura del Portal

- Página Principal con:
  - Tu nombre y fotografía tipo pasaporte.
  - Menú de navegación accesible desde todas las páginas.
- Secciones independientes para cada API.
- Estilos personalizados según temática de cada API.
- Formularios interactivos en las APIs que aceptan parámetros.
- Mensajes amigables ante errores de entrada o fallos en la API.

---

## 🔟 APIs Implementadas

1. ### 👦👧 Predicción de Género
   - **API:** https://api.genderize.io/?name=irma  
   - Formulario para ingresar un nombre y mostrar si es masculino (💙) o femenino (💖).

2. ### 🎂 Predicción de Edad
   - **API:** https://api.agify.io/?name=meelad  
   - Categoriza por edad (👶, 🧑, 👴) e incluye imágenes relacionadas.

3. ### 🎓 Universidades por País
   - **API:** http://universities.hipolabs.com/search?country=Dominican+Republic  
   - Ingreso del país en inglés para listar universidades, dominios y enlaces.

4. ### 🌦️ Clima en RD
   - **API:** https://wttr.in/ 
   - Muestra clima actual en RD o en una ciudad ingresada por el usuario.

5. ### ⚡ Pokémon Info
   - **API:** https://pokeapi.co/api/v2/pokemon/pikachu  
   - Detalles de un Pokémon, su imagen, habilidades y sonido.

6. ### 📰 Noticias desde WordPress
   - **API:** https://techcrunch.com/wp-json/wp/v2/posts 
   - Últimas 3 noticias de una página WordPress con titulares y resúmenes.

7. ### 💰 Conversión de Monedas
   - **API:** https://api.exchangerate-api.com/v4/latest/USD  
   - Convierte dólares (USD) a pesos dominicanos (DOP) y más.

8. ### 🖼️ Generador de Imágenes con IA
   - **API:** https://api.cloudflare.com/client/v4/accounts/$accountId/ai/run/@cf/black-forest-labs/flux-1-schnell
   - Busca imágenes con base en una palabra clave ingresada.

9. ### 🌍 Datos de un País
   - **API:** https://restcountries.com/v3.1/name/dominican  
   - Muestra bandera, capital, población y moneda de un país.

10. ### 🤣 Generador de Chistes
    - **API:** https://official-joke-api.appspot.com/random_joke  
    - Muestra un chiste aleatorio en cada visita.

---

## ✅ Funcionalidades y Buenas Prácticas

- Diseño responsivo y adaptable.
- Navegación fluida entre páginas.
- Formularios validados y con mensajes de error amigables.
- Código modular, limpio y comentado.
- Animaciones suaves para mejorar la experiencia visual.
- Página "Acerca de" explicando el enfoque y decisiones técnicas.

---

## 🧪 Cómo probar

1. Clona este repositorio:
   ```bash
   git clone https://github.com/JosueIsOffline/web-programming-itla

2. Asegúrate de tener PHP instalado.
   
3. Levanta un servidor local:
   ```
       php -S localhost:8000 -t public/

