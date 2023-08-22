<script>
import Swal from 'sweetalert2';
export default {
  data() {
    return {
      consulta: [],
      crono: {}
    };
  },
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
     // console.log(this.crono);

      const datosEnviar = {
        id_evento: this.crono.id_evento,
        fecha_inicio: this.crono.fecha_inicio,
        hora_inicio: this.crono.hora_inicio,
        fecha_fin: this.crono.fecha_cierre, // Cambiado para coincidir con el formulario
        hora_fin: this.crono.hora_cierre
      }

      fetch('http://localhost/suplos/index.php/?crono=1',{
        method: "POST",
        body:JSON.stringify(datosEnviar)

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
  }
};
</script>

<template>
    <div class="cronogram">
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
    <div>
        <p class="info">Cronograma</p>
        <div class="cuerpol">
            <form v-on:submit.prevent="agregarRegistro">
                <div class="row">
  <div class="col">
    <label for="">Fecha Inicio(*)</label>
    <input type="date" name="fecha_inicio" id="fecha_inicio" v-model="crono.fecha_inicio" class="form-control" placeholder="First name" aria-label="First name" required>
  </div>
  <div class="col">
    <label for="">Hora Inicio(*)</label>
    <input type="time" name="hora_inicio" v-model="crono.hora_inicio" class="form-control" placeholder="Last name" aria-label="Last name" required>
  </div>
  <div class="col">
    <label for="">Fecha de Cierre(*)</label>
    <input type="date" name="fecha_cierre" v-model="crono.fecha_cierre" class="form-control" placeholder="Last name" aria-label="Last name" required>
  </div>
  <div class="col">
    <label for="">Hora Cierre(*)</label>
    <input type="time" name="hora_cierre" class="form-control" v-model="crono.hora_cierre" placeholder="Last name" aria-label="Last name" required>
  </div>
</div>
<div class="row">
  <div class="col">
    <label for="id_evento">Objeto</label>
      <select name="id_evento" v-model.number="crono.id_evento" class="form-control" aria-placeholder="Seleccione" required>
        <option v-for="objeto in consulta" :key="objeto.id" :value="objeto.id" >{{ objeto.id }}</option>
      </select>
 </div>
</div>
<div class="botn">
            <button type="submit" class="btn btn-success"> Guardar</button>
        </div>
        
            </form>
        </div>
        <hr class="hrs">
    </div>
        
    </div>
</template>

<style>
.botn{
   margin-left: 440px;
   margin-top:20px;
}
label{
    color: gray;
    font-size: 12px;
}
.cuerpol{
    margin-left:-280px;
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
.cronogram{
    margin-left: -200px;
    margin-top: -270px;
    position: fixed;
}
.hrs{
    color: black;
    width: 1000px;
    margin-left: -300px;
    margin-top: 30px;
}
</style>
