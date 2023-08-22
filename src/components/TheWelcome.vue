<script setup>
import WelcomeItem from './WelcomeItem.vue'
import DocumentationIcon from './icons/IconDocumentation.vue'
import ToolingIcon from './icons/IconTooling.vue'
import EcosystemIcon from './icons/IconEcosystem.vue'
import CommunityIcon from './icons/IconCommunity.vue'
import SupportIcon from './icons/IconSupport.vue'
</script>

<template>
  <div class="home">
    <nav>
        <RouterLink to="/botones">Procesos/Eventos</RouterLink>
      </nav>
  </div>

</template>

<style>
.home{
 margin-left: -660px;
 margin-top: -200px;
}
.boton {
  display: flex;
  gap: 10px; /* Espacio entre los botones */
}
</style>
