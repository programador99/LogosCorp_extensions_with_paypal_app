define([
  'Vue',
  'LogosCorp_StoreLocator/js/lib/vue-i18n',
  'vue!LogosCorp_StoreLocator/js/components/App',
  'vue!LogosCorp_StoreLocator/js/components/VueFuse',
  'vue!LogosCorp_StoreLocator/js/components/StoreCard',
  'vue!LogosCorp_StoreLocator/js/components/App',
], function (Vue, VueI18n) {
  'use strict';

  return function (config) {
    Vue.use(VueI18n);

    const en_US = {
      "title": "Select your store",
      "search.form": "Find your preferred store",
      "current.location": "Use your current location",
      "visit.store.check": "Go to store",
      "distance.error": "Distance not available",
      "open": "Open:",
      "phone": "Telephone:",
      "address": "Address:",
      "maps": "Location",
      "preferred.store": "Preferred store",
      "select.store": "Select store",
      "visit.store": "Go to store",
      "redirect.title": "Confirmation",
      "redirect.content": "Your closest store is the <strong>%{store}</strong> store. <br /> Do you want to go to the store? <br/><br/><label class='localization-favstore-check'><input id='dontAsk' type='checkbox'>Don't ask again</label>",
      "redirect.cancel": "Cancel",
      "redirect.confirm": "Go to store"
    };
  
    const es_VE = {
      "title": "Selecciona tu tienda",
      "search.form": "Busca tu sucursal de preferencia",
      "current.location": "Usar tu ubicación actual",
      "visit.store.check": "Visitar",
      "distance.error": "Distancia no disponible",
      "open": "Abierto:",
      "phone": "Teléfono:",
      "address": "Dirección:",
      "maps": "Cómo llegar",
      "preferred.store": "Tienda favorita",
      "select.store": "Seleccionar tienda",
      "visit.store": "Seleccione esta tienda",
      "redirect.title": "Confirmación",
      "redirect.content": "Su tienda más cerca es la tienda de <strong>%{store}</strong>. <br /> ¿Desea ir a la tienda? <br/><br/><label class='localization-favstore-check'><input id='dontAsk' type='checkbox'>No volver a preguntar</label>",
      "redirect.cancel": "Cancelar",
      "redirect.confirm": "Ir a tienda"
    };
    
    const i18n = new VueI18n({
      locale: config.storeLocale,
      messages: {
        es_VE: es_VE,
        en_US: en_US
      }
    })
    
    new Vue({
      i18n,
    }).$mount('#app');  
  
  }
})
