class Paginator {
  constructor(
    items,
    itemsPerPage,
    containerId,
    paginationId,
    searchId,
    fragmentHTML,
    idFilter,
    callbackButton,
    objValidationImg = undefined,
  ) {
    this.items = items;
    this.itemsPerPage = itemsPerPage;
    this.currentPage = 1;
    this.filteredItems = items; // Para almacenar los elementos filtrados
    this.containerId = containerId;
    this.paginationId = paginationId;
    this.searchId = searchId;
    this.html = "";
    this.fragmentHTML = fragmentHTML; //para colocar el html dinamico de las tarjetas
    this.idFilter = idFilter;
    this.callbackButton = callbackButton;
    this.objValidationImg = objValidationImg;

    // Agregar evento de búsqueda
    const searchInput = document.getElementById(this.searchId);
    // Se registra el listener una sola vez por instancia. Si el módulo vuelve a
    // crear el Paginator, `searchListenerRef` permite liberar el anterior y así
    // no acumular N listeners sobre el mismo input.
    if (searchInput) {
      this._detachSearchListener?.();
      this.searchListenerRef = searchInput;
      this._searchHandler = () => this.searchItems(searchInput.value);
      searchInput.addEventListener("input", this._searchHandler);
    }
  }

  /** Libera el listener de búsqueda previamente registrado por esta instancia. */
  _detachSearchListener() {
    if (this.searchListenerRef && this._searchHandler) {
      this.searchListenerRef.removeEventListener("input", this._searchHandler);
    }
    this.searchListenerRef = null;
    this._searchHandler = null;
  }

  /**
   * Actualiza los datos del paginador reutilizando la instancia actual.
   * Evita crear un Paginator nuevo (y por tanto otro listener) en cada render.
   */
  setItems(items, { resetSearch = true } = {}) {
    this.items = items;
    this.filteredItems = items;
    this.currentPage = 1;

    const searchInput = document.getElementById(this.searchId);
    if (resetSearch && searchInput) searchInput.value = "";

    this.displayItems();
  }

  displayItems() {
    const startIndex = (this.currentPage - 1) * this.itemsPerPage;
    const endIndex = startIndex + this.itemsPerPage;

    const cardContainer = document.getElementById(this.containerId);
    if (!cardContainer) return;
    cardContainer.innerHTML = "";

    const currentItems = this.filteredItems.slice(startIndex, endIndex);

    this.html = ""; //Vaciar el html antes de llenarlo nuevamente
    if (currentItems.length > 0) {
      currentItems.forEach((item) => {
        this.html += this.fragmentHTML(item);
      });
    } else {
      this.html = `
      <div class="div-result-none">
      <h6 class='text-center' >No se encontraron resultados</h6>
      </div>`;
    }

    cardContainer.innerHTML = this.html;

    //Manejo del callbackButton para que no se reescriba la funcion de un elemeto html nuevamente
    const buttonsCard = cardContainer.querySelectorAll("button");

    buttonsCard.forEach((button) => {
      let idFilter = this.idFilter;

      button.addEventListener("click", (e) => {
        // e.target puede ser un hijo (svg/path/span) y no traer el data-index.
        const target = e.target.closest("[data-index]") ?? e.target;
        const itemId = target.getAttribute("data-index");
        const itemFilter = currentItems.find(
          (item) => item[idFilter] == itemId,
        );

        // Si no hay coincidencia no se invoca el callback: antes esto reventaba
        // con "Cannot read properties of undefined".
        if (!itemFilter) return;
        this.callbackButton(itemFilter[idFilter]);
      });
    });

    ///validar si la card tiene una imagen colocar una por defecto si no tiene pues no pasa nada.
    if (this.objValidationImg) {
      let imgSrcDefecto = this.objValidationImg.imgSrcDefecto;
      document.querySelectorAll(".card-img-top").forEach((img) => {
        this.objValidationImg.setImgWithFallback(img, img.src, imgSrcDefecto);
      });
    }

    this.updatePagination();
  }

  updatePagination() {
    const pagination = document.getElementById(this.paginationId);
    if (!pagination) return;
    pagination.innerHTML = "";

    const totalPages = Math.ceil(this.filteredItems.length / this.itemsPerPage);

    if (this.currentPage > 1) {
      const prevButton = document.createElement("button");
      prevButton.innerText = "«";
      prevButton.classList.add("pagination-porpia");
      prevButton.onclick = () => {
        this.currentPage--;
        this.displayItems();
      };
      pagination.appendChild(prevButton);
    }

    for (let i = 1; i <= totalPages; i++) {
      const pageButton = document.createElement("button");
      pageButton.innerText = i;
      pageButton.classList.add("pagination-porpia");
      pageButton.onclick = () => {
        this.currentPage = i;
        this.displayItems();
      };
      if (i === this.currentPage) {
        pageButton.disabled = true;
        pageButton.classList.add("pagination-disbled");
      }
      pagination.appendChild(pageButton);
    }

    if (this.currentPage < totalPages) {
      const nextButton = document.createElement("button");
      nextButton.innerText = "»";
      nextButton.classList.add("pagination-porpia");
      nextButton.onclick = () => {
        this.currentPage++;
        this.displayItems();
      };
      pagination.appendChild(nextButton);
    }
  }

  searchItems(query) {
    this.filteredItems = this.items.filter((item) =>
      Object.values(item).some((value) =>
        value.toString().toLowerCase().includes(query.toLowerCase()),
      ),
    );
    this.currentPage = 1; // Reiniciar a la primera página después de buscar
    this.displayItems();
  }
}

export default Paginator;
