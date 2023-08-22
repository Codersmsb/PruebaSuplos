
<script>
import Swal from 'sweetalert2'

    export default {
        el:'#app',
        data(){
            return{
                evento:{},
                excelData: [],
                searchTerm:'',
            }
        },
        methods: {
            fetchData(){
                if(this.searchTerm ===''){
                    alert('ingrese un termino de busqueda');
                    return;
                }
             fetch(`http://localhost/suplos/index.php?searchTerm=${this.searchTerm}`)
                .then(response=> response.json())
                .then( excelData=>{
                    this.excelData = excelData;
                })
                .catch(error=>{
                    console.error('Error',error);
                })
                    
            },

            agregarRegistro() {
                console.log("Método agregarRegistro ejecutado");
                console.log(this.evento);

                const datosEnviar={objeto:this.evento.objeto,descripcion:this.evento.descripcion,
                tipomoneda:this.evento.tipomoneda,presupuesto:this.evento.presupuesto,
                actividad:this.evento.actividad,responsable:this.evento.responsable
                }
                fetch('http://localhost/suplos/index.php/?insertar=1',{
                    method:"POST",
                    body:JSON.stringify(datosEnviar)
                    
                })
                .then(respuesta=>respuesta.json())
                .then((datosRespuesta=>{
                    console.log(datosRespuesta)
                    if (datosRespuesta.success === 1) {
      // Mostrar SweetAlert de éxito
      Swal.fire({
        icon: 'success',
        title: 'Éxito',
        text: 'El registro se ha guardado correctamente.'
        
    }).then(() => {
    window.location.reload(); // Recargar la página después del SweetAlert
  });
    } else {
      // Mostrar SweetAlert de error
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Ha ocurrido un error al guardar el registro.'
      });
    }
                }))
            },
            obtenerDatosExcel() {
    fetch('http://localhost/suplos/index.php?excel', {
        method: "GET"
    })
    .then(respuesta => respuesta.json())
    .then(datosRespuesta => {
        console.log(datosRespuesta); // Aquí recibirás los datos del archivo Excel en formato JSON
        
        // Aquí puedes procesar los datos recibidos y realizar las acciones necesarias
    })
    .catch(error => {
        console.error(error);
        // Manejo de errores
    });
}
        },
    }
</script>
<template>
    <div class="events">
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
      <div >
        <p class="info">Informacion Basica</p> 
        <div class="cuerpo">
            <form v-on:submit.prevent="agregarRegistro">
        <div class="inputs">
            <div class="input-container">
                <div class="mb-6">
                    <label for="objeto" class="form-label">Objeto</label>
                    <input type="text" name="objeto" v-model="evento.objeto" class="form-control" id="objeto" required>
                </div>
                <div class="mb-6">
                  <label for="descripcion" class="form-label">Descripcion/Alcance</label>
                    <textarea class="form-control" v-model="evento.descripcion"  name="descripcion" rows="3"  required></textarea>
                </div>
            <br>
            <div class="row">
                <div class="col">
                    <label for="tipomoneda">Moneda</label>
                    <label  class="presupuesto" for="presupuesto">Presupuesto</label>
                    <div class="input-group mb-3">
                        
                <span class="input-group-text"><i class='fas fa-list-ul'></i></span>
                <select name="tipomoneda" v-model="evento.tipomoneda"   class="form-control" id="tipomoneda"  required>
                    <option value="">Seleccione</option>
                    <option value="USD">USD</option>
                    <option value="EUR">EUR</option>
                    <option value="COP">COP</option>
                </select>
               
                <span class="input-group-text">$</span>
                <input type="number" v-model="evento.presupuesto" name="presupuesto"  class="form-control"  required >
           
                </div>
               
                </div>
            </div>
          
              
            </div>
            <div class="input-container">
               
                    
                <div class="mb-3">
                    <label for="responsable" class="form-label">Responsable</label>
                    <input type="text" v-model="evento.responsable" class="form-control" name="responsable" id="responsable"  required>
               
                </div>  
             
            </div>
            <div class="input-container">
               
               <div class="mb-6">
               
           </div> 
           <div class="mb-3">
                    <label for="actividad" class="form-label">Actividad</label>
                    <input type="text" v-model="evento.actividad" name="actividad" class="form-control" id="actividad"  required>
                </div> 
                <div class="mb-3">
                    <label for="consultar" class="form-label">Consultar</label>
                    <input type="text" v-model="searchTerm" name="consultar" class="form-control" id="consultar"  >
                </div> 
           <div  id="app">
            <button @click="fetchData" class="btn btn-light consult">
        Consultar Actividad
      </button>
    <div v-if="excelData.length > 0">
      <ul>
        <li v-for="(item, index) in excelData" :key="index">{{ item }}</li>
      </ul>
    </div>
  </div>
       </div>
        </div>
        <hr class="hrs">
         <div class="btn">
            <button type="submit" class="btn btn-success"> Guardar</button>
        </div>
    </form>

        </div>
       
       
        <hr class="hrs">
      </div>
       </div>
</template>
<style scoped>
.consult{
    margin-top: 28px;
    margin-left: -100px;
}

.presupuesto{
    margin-left:200px;
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
  }nav .ro {
    margin: 0 30px;
    text-decoration: none;
    font-size: 16px;
  }
.btn{
   margin-left: 70px;
}
.inputs{
    display: flex; 
    margin-left: -200px;
    justify-content: space-between; /* Agrega espacio entre los elementos */
}
.inputss{
    display: flex; 
    justify-content: space-between; /* Agrega espacio entre los elementos */
}
.input-container {
            flex: 1;
            margin-right: 18px; /* Ajusta el espacio entre los elementos */
        }
.input-container {
            flex: 1;
            margin-right: 18px; /* Ajusta el espacio entre los elementos */
        }
.events{
    margin-left: -200px;
    margin-top: 40px;
   
}
.info{
    margin-left:-300px; 
    color: gray;
    font-size: 18px;
}
.hrs{
    color: black;
    width: 1000px;
    margin-left: -300px;
    margin-top: 36px;
}
</style>

