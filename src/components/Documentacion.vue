<script>
import Swal from 'sweetalert2';
  export default {

    name: "ModalExample",
    data: () => ({
    consulta: [],
    doc: {
    }
  }),
  methods: { 
    visualizarObjetos() {
      fetch('http://localhost/suplos/index.php?eventos')
        .then(respuesta => respuesta.json())
        .then(datosRespuesta => {
          console.log(datosRespuesta);
          this.consulta = datosRespuesta;
        })
        .catch(error => {
          console.error('Error al obtener objetos:', error);
        });
    },
    agregarRegistro() {
      console.log("Método agregarRegistro ejecutado");
      console.log(this.doc);

      const datosEnviar = {
        id_evento: this.doc.id_evento,
        titulo: this.doc.titulo,
        descripcion: this.doc.descripcion
      }

      fetch('http://localhost/suplos/index.php/?doc=1', {
        method: "POST",
        body: JSON.stringify(datosEnviar)
      })
      .then(respuesta => {
          if (respuesta.status === 200) {
            // Mostrar SweetAlert de éxito
            Swal.fire({
              icon: 'success',
              title: 'Éxito',
              text: 'El registro se ha guardado correctamente.'
            }).then(() => {
              // Actualizar la vista de Vue aquí en lugar de recargar la página
              window.location.reload();
            });
          }else {
            // Mostrar SweetAlert de error
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Ha ocurrido un error al guardar el registro.'
            });
          }
          return respuesta.json();
        })
        .then(datosRespuesta => {
          console.log(datosRespuesta);
        })
        .catch(error => {
          console.error('Error al agregar registro:', error);
        });
    }
  },
    mounted() {
      this.visualizarObjetos();
     
      const openModalButton = document.getElementById("openModalButton");
      const closeModalButton = document.getElementById("closeModalButton");
      const modal = document.getElementById("myModal");

      openModalButton.addEventListener("click", () => {
        modal.style.display = "block";
      });

      closeModalButton.addEventListener("click", () => {
        modal.style.display = "none";
      });

      window.addEventListener("click", (event) => {
        if (event.target === modal) {
          modal.style.display = "none";
        }
      });
    },
    
  };
</script>
<template>
    <div class="doc">
        <div class="nave">
        <nav class="navv">
        <RouterLink class="ro" to="/eventos">Informacion Basica</RouterLink>
        <RouterLink class="ro" to="/cronograma">Cronograma</RouterLink>
        <RouterLink class="ro" to="/documentacion">Decoumentacion de peticion</RouterLink>
      </nav>
    </div>
    <div>
        <hr class="hrs">
    </div>
    <div class="">
        <p class="info">Contenido - Documentacion peticion de ofertas / Terminos y condiciones del proceso</p>
        <button class="btn btn-light btns" id="openModalButton">
     Agregar Contenido
    </button>
    </div>
    <hr class="hrs">
    </div>
        <!-- Modal -->
        <div class="modal" id="myModal">
      <div class="modal-content">
        <span class="close" id="closeModalButton">&times;</span>
        <!-- Tu formulario aquí -->
        <form v-on:submit.prevent="agregarRegistro">
          <div class="mb-3">
            <label for="titulo" class="form-label">Titulo</label>
            <input type="text" v-model="doc.titulo" class="form-control" id="titulo">
          </div>
          <div class="mb-3">
            <label for="id_evento" class="form-label">Id del evento / Proceso</label>
            <select name="id_evento" v-model.number="doc.id_evento" class="form-control" aria-placeholder="Seleccione">
              <option value="">Seleccione</option>
              <option v-for="objeto in consulta" :key="objeto.id" :value="objeto.id" >{{ objeto.id }}</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="descripcion">Descripcion</label>
            <textarea name="descripcion" v-model="doc.descripcion" class="form-control" rows="3"></textarea>
          </div>
          <div class="btnmodal">
            <button type="submit" class="btn btn-success ">Guardar</button>
          </div>
       </form>
      </div>
    </div>
</template>

<style scoped>
.btnmodal{
    align-items: center;
    align-content: center;
    text-align: center;
}
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
  }

  .modal-content {
    background-color: white;
    margin: 10% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%;
  }

  .close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
  }

  .close:hover,
  .close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
  }
.btns{
    margin-left: -300px;
}
.info{
    margin-left:-300px; 
    color: gray;
    font-size: 18px;
}
nav {
    display: flex;
    color: white;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    justify-content: center;
    align-items: center;
  }
  .nave{
    margin-left: -300px;
  }
  nav .ro {
    margin: 0 30px;
    text-decoration: none;
    font-size: 16px;
  }
.doc{
    margin-left: -200px;
    margin-top: -270px;
}
.hrs{
    color: black;
    width: 1000px;
    margin-left: -300px;
    margin-top: 30px;
}
</style>
