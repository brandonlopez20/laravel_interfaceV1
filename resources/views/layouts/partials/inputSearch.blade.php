<div class="input-search-container">
  <div class="search-container">
    <input type="text" id="input-search" autocomplete="off" placeholder="Buscar..." class="input-search">
    <button class="search-button" id="search-btn" onclick="resetValue()">
      @svg('vaadin-close-circle')
    </button>
  </div>
  <div class="options-container">
    <div class="options-search">
    </div>
  </div>
</div>


<script defer>
  const inputSearch = $('#input-search');
  const container = $('.options-search');
  const btnSearch = $('#search-btn');


  inputSearch.addEventListener('input', () => FilterByOptions())


  function resetValue() {
    const elements = $$('.search-option'); // Selecciona todos los elementos con la clase 'search-option'
      const containermenumain = $('#container-menu-main');
      container.style.border = 'none';
      containermenumain.style.filter = 'blur(0)';
      elements.forEach(element => {
        element.remove(); // Elimina cada elemento
      });
    return inputSearch.value = "";
  }

  function FilterByOptions() {
    container.innerHTML = ''; // Limpiar el contenedor antes de comenzar
    container.style.border = 'none'; // Restablecer el borde
    const value = inputSearch.value.toLowerCase();
    const containermenumain = $('#container-menu-main');
    containermenumain.style.filter = 'blur(10px)';

    let filteredDivs = [];

    if (value === "") {
      // Manejo del caso en que el campo de búsqueda esté vacío
      filteredDivs.push({
        spanText: "El campo de búsqueda está vacío.",
        svgIcon: '@svg("eva-close-circle", "menu-icon-options")',
        href: '#'
      });
    } else {
      // Filtrado normal
      filteredDivs = Array.from($$('a.o8f95')).reduce((acc, anchor) => {
        const div = anchor.querySelector('div');
        if (div && div.textContent.toLowerCase().includes(value)) {
          const spanText = div.querySelector('span')?.textContent || '';
          const svgIcon = div.querySelector('svg')?.outerHTML || '';
          const href = anchor.getAttribute('data-path');
          acc.push({
            spanText,
            svgIcon,
            href
          });
        }
        return acc;
      }, []);

      // Si no se encuentra ninguna coincidencia
      if (filteredDivs.length === 0) {
        filteredDivs.push({
          spanText: "No se encontraron resultados.",
          svgIcon: '@svg("eva-close-circle", "menu-icon-options")',
          href: '#'
        });
      }
    }


    filteredDivs.forEach(({
      spanText,
      svgIcon,
      href
    }) => {
      renderOption(spanText, svgIcon, href);
    });
  }


  function renderOption(name, icon, path = '#') {
    const optionElement = document.createElement('div');
    optionElement.classList.add('search-option');
    optionElement.addEventListener('click', () => {
      window.location.href = path
    });
    optionElement.innerHTML = `
      ${icon}
      <a href="${path}" class="link-option">${name}</a>
    `;

    container.appendChild(optionElement);

    // Añadir evento de clic para cerrar la opción si es un error
    if (path === '#') {
      optionElement.querySelector('a').addEventListener('click', function() {
        optionElement.remove();
        resetValue();
        if (container.children.length === 0) {
          container.style.border = 'none';
        }
      });
    } else {
      container.style.border = '1px solid var(--txt-dark-color);';
    }
  }
</script>


<style>
  .search-container {
    display: flex;
  }

  .menu-icon-option {
    width: 1.2rem;
  }

  .search-option {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    background: var(--bg-color);
    padding-left: 10px;
    padding-block: 10px;
  }

  .link-option {
    text-decoration: none;
    font-size: 1rem;
    font-weight: 400;
    color: var(--txt-color);
    margin-left: 10px;
  }

  .search-option:hover {
    filter: brightness(1.5);
    cursor: pointer;
  }

  .options-container {
    position: relative;
    top: 0;
    z-index: 1100;
    left: 0;
    width: 100%;
    max-height: 0;
  }

  .options-search {
    display: flex;
    flex-direction: column;
    width: 100%;
    border-radius: 10px;
    color: var(--txt-color);
    overflow-y: auto;
    max-height: 160px;
  }

  .input-search-container {
    display: flex;
    flex-direction: column;
    border: 1px solid var(--txt-dark-color);
    border-radius: 10px;
    margin-inline: 8px;
    margin-block: 15px;
  }

  .input-search {
    border: none;
    padding: 10px;
    font-size: 14px;
    /* Aumentar el tamaño del texto */
    font-weight: 700;
    color: var(--txt-color);
    background: var(--bg-color);
    /* Color de fondo del campo de entrada */
    width: 100%;
    box-sizing: border-box;
    outline: none;
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
  }

  .input-search:focus {
    border: 2px solid var(--txt-dark-color);
    filter: brightness(1.5);
  }

  .input-search::placeholder {
    color: var(--txt-color);
  }

  .search-button {
    background: var(--txt-dark-color);
    border: none;
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
    padding: 10px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .search-button:hover {
    filter: brightness(1.2);
  }

  .search-button svg {
    width: 1rem;
    color: var(--txt-light-color);
    /* Color del ícono */
  }

  .search-button:focus {
    outline: none;
  }
</style>