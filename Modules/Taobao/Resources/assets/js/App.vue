<template>
    <div>
        <keep-alive>
            <router-view v-if="$route.meta.keepAlive"></router-view>
        </keep-alive>
        <router-view v-if="!$route.meta.keepAlive"></router-view>
    </div>
</template>
<script scoped>
  export default {
    name:'App',
    data(){
      return {}
    },
    components: {},
    computed: {},
    mounted() {},
    methods: {}
  }
</script>