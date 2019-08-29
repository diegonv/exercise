<template>
  <div>     
    <post v-for="post in posts"
      :key="post._id"
      :post="post"
      :editable="false"
       />
  </div>
</template>

<script>
export default {
  data() {
    return {
      posts: [],
    }
  },
  created(){
    axios.get('/api/posts').then(res=>{
      this.posts = res.data;
    })
  },
}
</script>