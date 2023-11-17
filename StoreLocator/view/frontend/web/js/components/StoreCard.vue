<template>
  <div>
    <!-- HEADER -->
    <div class="localization-store-header">
      <label class="store-header" :for="store.store_id">
        {{ store.name }}
      </label>
      <span class="localization-distance" v-if="store.distance">
        {{ store.distance.toFixed(2) }} km
      </span>
      <span v-else class="localization-distance-error">
        {{ this.$i18n.t('distance.error') }}
      </span
      >
    </div>
    <!-- STORE TIME -->
    <div class="localization-store-info-time">
      <span class="sub-title">
        {{ this.$i18n.t('open') }}
      </span>
      <span class="description" v-html="formatHours(store.schedule)">

      </span>
    </div>
    <!-- STORE PHONE -->
    <div class="localization-store-info-contact">
      <span class="sub-title">
        {{ this.$i18n.t('phone') }}
      </span>
      <span class="description" v-html="formatPhone(store.phones)">

      </span>
    </div>
    <!-- STORE INFO -->
    <div class="localization-store-info-base">
      <span class="sub-title">
        {{ this.$i18n.t('address') }}
      </span>
      <span class="description">
        {{ store.street_line1 }}
      </span>
    </div>
    <!-- STORE DETAILS -->
    <div class="localization-store-info-details">
      <a class="store-show-location" target="_blank" :href="'https://maps.google.com/maps?q=' + store.latitud + ',' + store.longitud">
				{{ this.$i18n.t('maps') }}
      </a>
      <!-- Favorite Store -->
      <label v-if="customerId" class="favorite-store" :class="isChecked ? 'is-checked':''">
        <input
          name="favorite-store"
          type="checkbox"
          title="{{ this.$i18n.t('preferred.store') }}"
          :checked="isChecked"
          @input="handlePreferredStore"
          hidden
        />
      </label>
    </div>
    <!-- STORE CHECK -->
    <div class="localization-store-check">
      <input
        :id="store.store_id"
        name="selected-store"
        type="radio"
        title="{{ this.$i18n.t('select.store') }}"
        :checked="store.store_id == currentStoreId"
        :value="store.store_id"
        @input="handleSelectedStore"
      />
      <label :for="store.store_id" class="label">
        {{ this.$i18n.t('select.store') }}
      </label>
    </div>
	<!-- GO TO STORE -->
	<div class="localization-visit-store-action">
		<button class="localization-visit-store-button" :href="store.website_url" @click="visitStore">
			{{ this.$i18n.t('visit.store') }}
		</button>
	</div>
  </div>
</template>

<script>
define([
  "Vue",
], function (Vue) {
  Vue.component("store-card", {
    template: template,
    props: {
      store: Object,
      customerId: Number,
      preferredStoreId: Number,
      currentStoreId: Number,
    },
    data() {
      return {
        hide: true,
      };
    },
    computed: {
      isChecked() {
        return this.store.store_id === this.preferredStoreId;
      },
    },
    methods: {
      handlePreferredStore(e) {

        const storeId = (e.target.checked) ? this.store.store_id : null;

        if (storeId != null) {
          this.$emit('preferred-store', storeId);
        }

      },
      handleSelectedStore(e) {
        this.$emit('selected-store-parent', this.store.website_url);
      },
      async visitStore() {
        window.location.replace(this.store.website_url)
      },
      formatHours(hours) {
        var html = '';

        hours.forEach((element) => {
          html += element + '<br>';
        });

        return html;
      },
      formatPhone(phones) {
        var html = '';

        phones.forEach((element) => {
          html += '<a class="store-phone-link" href="tel:' + element.replaceAll('-', '') + '">' + element + '</a><br>';
        });

        return html;
      },
    },
  });
});
</script>

<style>
.localization-store-info-contact {
  display: block;
}

.localization-map-view.hidden {
  display: none;
}

.localization-store-info-details {
  display: flex;
  justify-content: space-between;
}

.localization-distance-error {
  color: orange;
  text-transform: uppercase;
}

.localization-favstore-check {
  font-weight: bold;
}

.localization-visit-store-btn {
  border-width: medium;
  width: -webkit-fill-available;
  justify-content: center;
}

.localization-store-header {
  position: relative;
}

input[type="checkbox"].favorite-store {
  position: absolute;
  right: 0;
  top: 0;
  visibility: hidden;
  font-size: 30px;
  cursor: pointer;
  color: grey;
}

.favorite-store:before {
  content: "\2606";
  position: absolute;
  visibility: visible;
}
.favorite-store:checked:before {
  content: "\2605";
  position: absolute;
  transition: width 2s;
}
.localization-map-view iframe {
  width: 100%;
  height: auto;
}
</style>
