/**
 * Gestion de usuarios (pantalla admin)
 * Proporciona busqueda en tabla y helpers para modales CRUD.
 */
class UsuariosAdmin {
  constructor(options = {}) {
    this.tableId = options.tableId ?? "tablaUsuarios";
    this.searchId = options.searchId ?? "buscarUsuario";
    this.roleFilterId = options.roleFilterId ?? "filtroRol";
    this.filterButtonSelector =
      options.filterButtonSelector ?? '[data-user-action="filter"]';
    this.modalTargets = {
      view: options.viewModalId ?? "modalVerUsuario",
      edit: options.editModalId ?? "modalEditarUsuario",
      delete: options.deleteModalId ?? "modalEliminarUsuario",
    };
    this.viewContainerId = options.viewContainerId ?? "contenidoVerUsuario";
    this.editContainerId = options.editContainerId ?? "contenidoEditarUsuario";
    this.deleteNameId = options.deleteNameId ?? "usuarioAEliminar";
    this.deleteIdInputId = options.deleteIdInputId ?? "idUsuarioAEliminar";

    this.bootstrapModal = window.bootstrap?.Modal ?? null;
    this.handleClick = this.handleClick.bind(this);

    this.cacheDom();
    this.attachEventListeners();
  }

  cacheDom() {
    this.table = document.getElementById(this.tableId);
    this.searchInput = document.getElementById(this.searchId);
    this.roleFilter = document.getElementById(this.roleFilterId);
    this.filterButtons = Array.from(
      document.querySelectorAll(this.filterButtonSelector)
    );
  }

  attachEventListeners() {
    if (this.searchInput) {
      this.searchInput.addEventListener("input", () => this.filterTable());
    }

    if (this.roleFilter) {
      this.roleFilter.addEventListener("change", () => this.filterTable());
    }

    this.filterButtons.forEach((btn) => {
      btn.addEventListener("click", (event) => {
        event.preventDefault();
        this.filterTable();
      });
    });

    document.addEventListener("click", this.handleClick);
  }

  handleClick(event) {
    const actionButton = event.target.closest("[data-user-action]");
    if (!actionButton) {
      return;
    }

    const action = actionButton.dataset.userAction;
    const id = actionButton.dataset.userId;
    if (!action || !id) {
      return;
    }

    if (action === "view") {
      this.viewUser(id);
    } else if (action === "edit") {
      this.editUser(id);
    } else if (action === "delete") {
      this.deleteUser(id);
    }
  }

  filterTable() {
    if (!this.table) {
      return;
    }

    const searchValue = (this.searchInput?.value ?? "").toLowerCase();
    const roleValue = (this.roleFilter?.value ?? "").toLowerCase();
    const rows = Array.from(this.table.querySelectorAll("tbody tr"));

    rows.forEach((row) => {
      const textContent = row.textContent.toLowerCase();
      const role = (row.dataset.role ?? "").toLowerCase();

      const matchesSearch = !searchValue || textContent.includes(searchValue);
      const matchesRole = !roleValue || role.includes(roleValue);

      row.style.display = matchesSearch && matchesRole ? "" : "none";
    });
  }

  viewUser(id) {
    const user = this.extractUserData(id);
    if (!user || !this.bootstrapModal) {
      return;
    }

    const target = document.getElementById(this.viewContainerId);
    if (target) {
      target.innerHTML = this.renderViewMarkup(user);
    }

    this.openModal(this.modalTargets.view);
  }

  editUser(id) {
    const user = this.extractUserData(id);
    if (!user || !this.bootstrapModal) {
      return;
    }

    const target = document.getElementById(this.editContainerId);
    if (target) {
      target.innerHTML = this.renderEditMarkup(user);
    }

    this.openModal(this.modalTargets.edit);
  }

  deleteUser(id) {
    const user = this.extractUserData(id);
    if (!user || !this.bootstrapModal) {
      return;
    }

    const nameEl = document.getElementById(this.deleteNameId);
    if (nameEl) {
      nameEl.textContent = user.username;
    }

    const idInput = document.getElementById(this.deleteIdInputId);
    if (idInput) {
      idInput.value = user.id;
    }

    this.openModal(this.modalTargets.delete);
  }

  openModal(modalId) {
    const modalElement = modalId ? document.getElementById(modalId) : null;
    if (modalElement && this.bootstrapModal) {
      const modal = new this.bootstrapModal(modalElement);
      modal.show();
    }
  }

  extractUserData(id) {
    if (!this.table) {
      return null;
    }

    const rawId = String(id);
    const escapedId =
      typeof CSS !== "undefined" && typeof CSS.escape === "function"
        ? CSS.escape(rawId)
        : rawId.replace(/"/g, '\\"');

    const row = this.table.querySelector(
      `tbody tr[data-user-id="${escapedId}"]`
    );
    if (!row) {
      return null;
    }

    const datasetUser = row.dataset;
    if (datasetUser && datasetUser.username) {
      return {
        id: datasetUser.userId ?? rawId,
        username: datasetUser.username,
        email: datasetUser.email ?? "",
        fullName: datasetUser.fullName ?? "",
        firstName: datasetUser.firstName ?? "",
        lastName: datasetUser.lastName ?? "",
        phone: datasetUser.phone ?? "",
        city: datasetUser.city ?? "",
        role: (datasetUser.role ?? "user").toLowerCase(),
      };
    }

    const cells = row.querySelectorAll("td");
    if (cells.length === 0) {
      return null;
    }

    const usernameCell = cells[1]?.querySelector("strong");
    const fullName = cells[3]?.textContent.trim() ?? "";
    const nameParts = fullName.split(/\s+/);

    return {
      id: cells[0]?.textContent.trim() ?? rawId,
      username: usernameCell?.textContent.trim() ?? "",
      email: cells[2]?.textContent.trim() ?? "",
      fullName,
      firstName: nameParts.shift() ?? "",
      lastName: nameParts.join(" "),
      phone: cells[4]?.textContent.replace(/[^\d+]/g, "") ?? "",
      city: cells[5]?.textContent.trim() ?? "",
      role: (cells[6]?.textContent || "user").toLowerCase().includes("admin")
        ? "admin"
        : "user",
    };
  }

  renderViewMarkup(user) {
    const roleBadge = user.role === "admin" ? "warning" : "success";
    const roleLabel = user.role.charAt(0).toUpperCase() + user.role.slice(1);
    const phone = user.phone || "Sin telefono";
    const city = user.city || "Sin especificar";

    return `
            <div class="row">
                <div class="col-md-6">
                    <div class="card border-primary mb-3">
                        <div class="card-header bg-primary text-white">
                            <i class="fas fa-key"></i> Datos de acceso
                        </div>
                        <div class="card-body">
                            <p><strong>ID:</strong> ${user.id}</p>
                            <p><strong>Usuario:</strong> ${user.username}</p>
                            <p><strong>Rol:</strong>
                                <span class="badge bg-${roleBadge}">${roleLabel}</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-info mb-3">
                        <div class="card-header bg-info text-white">
                            <i class="fas fa-user"></i> Datos personales
                        </div>
                        <div class="card-body">
                            <p><strong>Nombre:</strong> ${user.fullName}</p>
                            <p><strong>Email:</strong> <a href="mailto:${user.email}">${user.email}</a></p>
                            <p><strong>Telefono:</strong> ${phone}</p>
                            <p><strong>Ciudad:</strong> ${city}</p>
                        </div>
                    </div>
                </div>
            </div>
        `;
  }

  renderEditMarkup(user) {
    const roleUserSelected = user.role === "user" ? "selected" : "";
    const roleAdminSelected = user.role === "admin" ? "selected" : "";

    return `
            <input type="hidden" name="id" value="${user.id}">
            <div class="row">
                <div class="col-12">
                    <h6 class="text-primary mb-3">
                        <i class="fas fa-key"></i> Datos de acceso
                    </h6>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Usuario *</label>
                        <input type="text" class="form-control" name="usuario" value="${user.username}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Rol *</label>
                        <select class="form-control" name="rol" required>
                            <option value="user" ${roleUserSelected}>Usuario</option>
                            <option value="admin" ${roleAdminSelected}>Administrador</option>
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <hr>
                    <h6 class="text-primary mb-3">
                        <i class="fas fa-user"></i> Datos personales
                    </h6>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nombre *</label>
                        <input type="text" class="form-control" name="nombre" value="${user.firstName}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Apellidos *</label>
                        <input type="text" class="form-control" name="apellidos" value="${user.lastName}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" class="form-control" name="email" value="${user.email}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Telefono</label>
                        <input type="tel" class="form-control" name="telefono" value="${user.phone}">
                    </div>
                </div>
            </div>
        `;
  }
}
