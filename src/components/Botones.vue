<template>
  <div class="evento">
    <div class="boton">
      <button class="btn btn-primary" @click="$router.push('/eventos')">
        <i class="fas fa-edit"></i> <br> Crear
      </button>
      <button class="btn btn-primary">
        <i class="fas fa-copy"></i> <br> Copiar
      </button>
      <button class="btn btn-primary"  @click="$router.push('/consultas')">
        <i class="fas fa-search"></i> <br> Consultar
      </button>
    </div>
    </div>
</template>
<script>

</script>
<style>
.evento{
 margin-left: -130px;
 margin-top: -280px;
}
.boton {
  display: flex;
  gap: 10px; /* Espacio entre los botones */
}
</style>