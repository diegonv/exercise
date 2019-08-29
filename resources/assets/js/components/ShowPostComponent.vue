<template>
  <div>
    <span 
      v-for="(item, index) in posts" :key="index" >
      <div class="post-preview">
        <span class="badge badge-primary float-right">
          {{item.updated_at}}
        </span>
        <h2 class="post-title">{{item.nombre}}</h2>
        <h3 v-if="username.length>=8" class="post-subtitle">{{item.content.substring(0,20)+".."}}</h3>
        <h3 v-else class="post-subtitle">{{item.content}}</h3>
      </div>
      <hr>
    </span>
  </div>
</template>

<script>
export default {
  data() {
    return {
      post: [],
      modoEditar: false,
      post: {nombre: '', content: ''}
    }
  },
  created(){
    axios.get('/api/posts').then(res=>{
      this.posts = res.data;
    })
  }
}
</script>