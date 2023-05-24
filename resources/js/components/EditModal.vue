<template>
  <div class="container modal-dialog">
    <div class="row">
      <div class="col-lg-12">
        <div class="card modal-content">
          <div
            class="card-header text-center bg-warning d-flex justify-content-between"
          >
            Editar Datos Personales
            <button
              type="button"
              class="btn-close align-self-end"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-sm-3 d-flex justify-content-end">
                <h6 class="mb-0">Full Name</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <input type="text" class="form-control" value="John Doe" />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-3 d-flex justify-content-end">
                <h6 class="mb-0">Email</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <input
                  type="text"
                  class="form-control"
                  value="john@example.com"
                />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-3 d-flex justify-content-end">
                <h6 class="mb-0">Phone</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <input
                  type="text"
                  class="form-control"
                  value="(239) 816-9029"
                />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-3 d-flex justify-content-end">
                <h6 class="mb-0">Mobile</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <input
                  type="text"
                  class="form-control"
                  value="(320) 380-4539"
                />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-3 d-flex justify-content-end">
                <h6 class="mb-0">Address</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <input
                  type="text"
                  class="form-control"
                  value="Bay Area, San Francisco, CA"
                />
              </div>
            </div>
            <div class="row">
              <div class="col-sm-3 d-flex justify-content-end"></div>
              <div
                class="col-sm-9 text-secondary d-flex justify-content-between"
              >
                <input
                  type="button"
                  class="btn btn-primary px-4"
                  value="Save Changes"
                />
                <button
                  type="button"
                  class="btn btn-danger align-self-end"
                  data-bs-dismiss="modal"
                >
                  Cancelar
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Form from "vform";
export default {
  data() {
    return {
      form: new Form({}),
    };
  },
};
</script>

<style scoped>
.card {
  position: relative;
  display: flex;
  flex-direction: column;
  min-width: 0;
  word-wrap: break-word;
  background-clip: border-box;
  border-radius: 0.25rem;
  margin-bottom: 1.5rem;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.2), 0 1px 2px 0 rgba(0, 0, 0, 0.46);
}

@media (max-width: 576px) {
  .col-sm-3 {
    justify-content: start !important;
  }
}
</style>