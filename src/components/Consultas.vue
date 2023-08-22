
<script>
//import XLSX from 'xlsx';
import * as XLSX from 'xlsx';
export default {
  data() {
    return {
      eventos: [],
      idBusqueda: "", // Variable para almacenar el ID de búsqueda
      responsable: "",// Variable para el Responsable de búsqueda
      objeto: "", //Variable para el Objeto de busqueda
      estado:"",
      
    };
  },
  mounted() {
    this.fetchEventos();
  },
  methods: {
    buscarEventos() {
      if (this.idBusqueda !== "") {
        fetch(`http://localhost/suplos/index.php/?fds=1&evento_id=${this.idBusqueda}`)
          .then(response => response.json())
          .then(data => {
            if (data.success !== 0) {
              this.eventos = data;
            } else {
              this.eventos = [];
            }
          })
          .catch(error => {
            console.error('Error fetching data:', error);
          });
      } if (this.responsable !== "") 
      {
        fetch(`http://localhost/suplos/index.php/?cpr=1&responsable=${this.responsable}`)
          .then(response => response.json())
          .then(data => {
            if (data.success !== 0) {
              this.eventos = data;
            } else {
              this.eventos = [];
            }
          })
          .catch(error => {
            console.error('Error fetching data:', error);
          });
      }

      if (this.objeto !== "") 
      {
        fetch(`http://localhost/suplos/index.php/?cpo=1&objeto=${this.objeto}`)
        .then(response => response.json())
          .then(data => {
            if (data.success !== 0) {
              this.eventos = data;
            } else {
              this.eventos = [];
            }
          })
          .catch(error => {
            console.error('Error fetching data:', error);
          });
      }
      else if (this.estado !== "") {
        console.log(this.estado);
       fetch(`http://localhost/suplos/index.php/?cpes=1&estados=${this.estado}`)
       .then(response => response.json())
      .then(data => {
        if (data.success !== 0) {
          this.eventos = data;
        } else {
          this.eventos = [];
          
        }
      })
      .catch(error => {
        console.error('Error fetching data:', error);
      });
  }
      
    },
    prepareDataForExcel() {
      const excelData = this.eventos.map(evento => ({
        id: evento.id_evento,
        Objeto: evento.objeto,
        Descripcion: evento.descripcion,
        'fechainicio': evento.fecha_inicio,
        'fechacierre': evento.fecha_fin,
        Estado: evento.estado,
        Responsable: evento.responsable
      }));
      return excelData;
    },

    generarExcel() {
  const excelData = this.prepareDataForExcel();
  const ws = XLSX.utils.json_to_sheet(excelData);
  const wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, 'Eventos');

  // Crear el archivo Excel en formato de array de bytes
  const excelBuffer = XLSX.write(wb, { bookType: 'xlsx', type: 'array' });

  // Convertir el array de bytes en un blob
  const blob = new Blob([excelBuffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });

  // Crear un enlace y simular el clic para descargar el archivo
  const link = document.createElement('a');
  link.href = URL.createObjectURL(blob);
  link.download = 'eventos.xlsx';
  link.click();
},
    fetchEventos() {
      // Realizar la llamada a la API para obtener los datos en formato JSON
      // Puedes usar la función fetch o axios para esto
      fetch('http://localhost/suplos/index.php?cns')
        .then(response => response.json())
        .then(data => {
          if (data.success !== 0) {
            this.eventos = data;
          }
        })
        .catch(error => {
          console.error('Error fetching data:', error);
        });
    }
   
  },
};
</script>
<template>
  <div style="margin-top: 200px;">

<br>
       <p class="infos">Procesos / Eventos participacion cerrada</p>
        
       <p class="pbuscar">Busqueda</p>
       <div class="dform">
        <form action="">
            <div class="row divform">
                <div class="col">
              
                    <label for="idBusqueda">ID cerrada</label>
            <input
              type="text"
              name="idBusqueda"
              class="form-control"
              v-model="idBusqueda"
            >
                    <label for="">Estados</label>
                    <select name="estado" v-model="estado" class="form-control" id="estado">
                      <option value="">Seleccione</option>
                      <option  value="activo">Activo</option>
                      <option value="publicado">Publicado</option>
                      <option value="evaluado">Evaluado</option>
        
                    </select>
                </div>
                <div class="col">
                    <label for="">Responsable</label>
                    <input type="text" name="responsable"  v-model="responsable" class="form-control">
                </div>
                <div class="col">
                    <label for="">Objeto / Descripcion</label>
                    <input
              type="text"
              name="objeto"
              class="form-control"
              v-model="objeto"
            >
                </div>
            </div>
        </form>
       </div>
         </div>
       <br>
       <div style="margin-left: 800px;">
        <button class="btn btn-light" @click="buscarEventos">
        Buscar
      </button>
        <span></span>
        <button class="btn btn-success" style="margin-left: 20px;" @click="generarExcel">
    Generar Excel
</button>
       </div>
       <br>
       <div style="width: 1250px; margin-top: 200px; ">
        <table class="table" style="width: 1250px; margin-top:-150px; margin-left:-40px;">
      <thead>
        <tr>
          <th scope="col">Id</th>
          <th scope="col">Objeto</th>
          <th scope="col">Descripcion</th>
          <th scope="col">Fecha inicio</th>
          <th scope="col">Fecha cierre</th>
          <th scope="col">Estado</th>
          <th scope="col">Responsable</th>
        </tr>
      </thead>
      <tbody class="table-group-divider">
        <tr v-for="evento in eventos" :key="evento.id">
          <td>{{ evento.id_evento }}</td>
          <td>{{ evento.objeto }}</td>
          <td>{{ evento.descripcion }}</td>
          <td>{{ evento.fecha_inicio }}</td>
          <td>{{ evento.fecha_fin }}</td>
          <td>{{ evento.estado }}</td>
          <td>{{ evento.responsable }}</td>
        </tr>
      </tbody>
    </table>
       </div>
</template>

<style scoped>
.dform{
    margin-top:-20px;
  
}
.divform{
    margin-left:-50px;

}
.pbuscar{
    color: gray;
    font-size: 16px;
    margin-top: 0;
    margin-left: -50px;
    margin-top: -100px;
}
.infos{
    color: gray;
    font-size: 18px;
    position: absolute;
    top: 0;
    left: 0;
    margin: 20px;
}
.hrs{
    width:1280px;
    margin-left:-80px;
    margin-top: -105px;
   
}
</style>