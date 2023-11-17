<template>
	<div class="stores-app">
		<span class="title">{{ this.$i18n.t('title') }}</span>
		<!-- BUSCADOR -->
		<div class="store-form">
			<vue-fuse
				placeholder="this.$i18n.t('search.form')"
				:list="stores"
				:fuse-opts="options"
				:search="search"
				:map-results="true"
				@fuse-results="handleResults"
				ref="componentVueFuse"
			/>
		</div>

		<!-- CURRENT LOCATION -->
		<div class="localization-store-near-div">
			<button class="localization-store-near-btn" @click="restartResults">
				{{ this.$i18n.t('current.location') }}
			</button>
		</div>

		<!-- TIENDAS -->
		<div class="localization-store-list">
			<div class="store-list-item" v-for="(store, i) in websites" :key="i">
				<store-card
				:customer-id="customerId"
				:store="store"
				:preferred-store-id="favoriteStore"
				:current-store-id="currentStoreId"
				@preferred-store="handlePreferredStore"
				@selected-store-parent="selectedStoreParent"
				></store-card>
			</div>
		</div>

		<!-- Go TO THE STORE -->
		<div class="localization-store-action">
			<button 
				class="localization-visit-store-button" 
				:href="selectedStoreUrl" 
				@click="visitStore"
			>
				{{ this.$i18n.t('visit.store.check') }}
			</button>
		</div>
	</div>
</template>

<script>
define([
	"Vue", 
	"jquery", 
	"Magento_Ui/js/modal/confirm"
], function ( Vue, $, confirmation) {
  	Vue.component("app", {
		template: template,
		props: {
			dataStore: Object,
			items: String,
			customerId: Number,
			preferredStoreId: Number,
			isWidget: Boolean,
			currentStoreId: Number,
		},
		data() {
			return {
				websites: [],
				stores: [],
				search: "",
				latitud: 0,
				longitud: 0,
				favoriteStore: null,
				selectedStoreUrl: null,
				options: {
					keys: [
						{
							name: "name",
							weight: 2,
						},
						"city",
						"street_line1",
						"street_line2",
						"phone",
						"postcode",
					],
				},
			};
		},
		async created() {
			this.favoriteStore = this.preferredStoreId;
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(
					this.setCoordinates, // Asignamos las coordenadas si tenemos permiso para leer la ubicacion
					this.populateStores // Cargamos las tiendas si no tenemos permiso
				);
			}
		},
		computed: {
			website() {

				return JSON.parse(this.dataStore);

			},
		},
		methods: {
			/**
			 * Calcula la distencia entre 2 coordenadas
			 * @param {number} lat1 - Latitud desde donde se va a realizar el calculo
			 * @param {number} lon1 - Longitud desde donde se va a realizar el calculo
			 * @param {number} lat2 - Latitud hasta donde se va a realizar el calculo
			 * @param {number} lon2 - Longitud hasta donde se va a realizar el calculo
			 * @param {string} unit - Unidad de medida en la que devolvera la distancia
			 * @returns {number} Distancia calculada
			 */
			getDistance(lat1, lon1, lat2, lon2, unit = "K") {
				if (lat1 == lat2 && lon1 == lon2) {
					return 0;
				}

				let radlat1 = (Math.PI * lat1) / 180;
				let radlat2 = (Math.PI * lat2) / 180;
				let theta = lon1 - lon2;
				let radtheta = (Math.PI * theta) / 180;

				let dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);

				if (dist > 1) {
					dist = 1;
				}

				dist = Math.acos(dist);
				dist = (dist * 180) / Math.PI;
				dist = dist * 60 * 1.1515;

				if (unit == "K") {
					dist = dist * 1.609344;
				}
				
				if (unit == "N") {
					dist = dist * 0.8684;
				}

				return dist;
			},

			/**
			 * Obtenemos las coordenadas desde el navegador y se la asignamos a las propiedades
			 * latitud y longitud para luego preguntar si desea cambiar de Tienda
			 * @param {Object} position - Objecto que contiene las coordenadas
			 */
			setCoordinates(position) {
				this.latitud = position.coords.latitude;
				this.longitud = position.coords.longitude;

				// Cargamos el listado de tiendas
				this.populateStores();

				// Mostramos confirmacion de cambio de tienda si estamos en una tienda diferente
				const store = this.stores[0];
				const isHomepage = window.location.href === this.website.website_url;
				const noRedirectDialog = localStorage.getItem("dont-show-redirect-dialog") === "true";

				if (this.website.store_id !== store.store_id && !noRedirectDialog && isHomepage) this.showRedirectConfirm(store);
			},

			/**
			 * Carga la lista de tiendas
			 */
			populateStores() {
				const data = JSON.parse(this.items);

				// Excluir del arreglo las tiendas que tengan alguna coord null
				let storesWC = data.filter((item) => !item.latitud || !item.longitud);

				// Calculamos la distancia
				let stores = data
				.filter((item) => item.latitud && item.longitud)
				// Agregamos la propiedad `distance` a cada elemento
				.map((item) => {
					return {
					...item,
					distance: this.getDistance(
						this.latitud,
						this.longitud,
						item.latitud,
						item.longitud
					),
					};
				})
				// Ordenamos por Distancia
				.sort((a, b) => {
					if (a.distance < b.distance) return -1;
					if (a.distance > b.distance) return 1;
					return 0;
				})
				// Concatenamos las tiendas sin distancia
				.concat(storesWC);

				// Populate Stores
				this.stores = stores;
			},

			/**
			 * Metodo para obtener las tiendas filtradas por el buscador
			 * @param {Array} data
			 */
			handleResults(data) {
				this.websites = data;
			},

			/**
			 * Modal de Confirmacion para redireccionar al usuario de tienda
			 * @param {Object} store - Tienda a la que se quiere redireccionar
			 */
			showRedirectConfirm(store) {
				confirmation({
					title: this.$i18n.t('redirect.title'),
					content: this.$i18n.t('redirect.content', { store: store.name }),
					actions: {
						confirm: () => {
						window.location.replace(store.website_url);
						},
					},
					buttons: [
						{
							text: this.$i18n.t('redirect.cancel'),
							class: "action-secondary action-dismiss",
							click: function (event) {

								localStorage.setItem("dont-show-redirect-dialog", $("#dontAsk").prop("checked"));
								this.closeModal(event);

							},
						},
						{
							text: this.$i18n.t('redirect.confirm'),
							class: "action-primary action-accept",
							click: function (event) {

								localStorage.setItem("dont-show-redirect-dialog", $("#dontAsk").prop("checked"));
								this.closeModal(event, true);

							},
						},
					],
				});
			},

			/**
			 * FUNCTION TO STORE THE FAVORITE STORE
			 */
			async handlePreferredStore(storeId) {

				const prevFavoriteStore = this.favoriteStore;
				const url = '/rest/V1/logoscorp/store-locators/preferred-store/';
				const options = {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json'
					},
					body: JSON.stringify({
						customer_id: this.customerId,
						store_id: storeId,
					}),
				};

				fetch(url, options)
				.then(async response => {
					const data = await response.json();
					console.log('inside response');

					// Check for error response
					if (!response.ok) {

						this.favoriteStore = prevFavoriteStore;
						return Promise.reject(response.status);

					}

					// Logic to handle results
					const result = data[0];

					if (result.success) {	

						this.favoriteStore = storeId;	

					} else {

						this.favoriteStore = prevFavoriteStore;
						console.error('There was an error: ' + result.message);

					}
				})
				.catch(error => {

					this.favoriteStore = prevFavoriteStore;

					console.error('Something wrong happend: ' + error);
				});
			},

			/**
			 * FUNCTION TO RESET STORES 
			 */
			restartResults() {

				this.$refs.componentVueFuse.returnFirstOrder();

			},

			/**
			 * 
			 */
			selectedStoreParent(url) {
				this.selectedStoreUrl = url;
				console.log('selectedStoreUrl ', this.selectedStoreUrl);
			},

			/**
			 * 
			 */
      async visitStore() {
        if (this.selectedStoreUrl != null) window.location.replace(this.selectedStoreUrl)
      },
		},
  	});
});
</script>
