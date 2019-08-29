<template>
  <div>
    <h3>Admin</h3>
    <form @submit.prevent="newPost">
      <div class="text-right">
        <button class="btn btn-primary" type="submit">New Post</button>
      </div>
    </form>
    <hr> 
    <post v-for="post in posts"
      :key="post._id"
      :post="post"
      :editable="true"
      v-on:reload="reload"
       />
  </div>
</template>

<script>
export default {
  data() {
    return {
      posts: [],
      maxSubtitleLeng: process.env.MIX_MAX_SUBTITLE_LENG
    }
  },
  created(){
    this.reload();
  },
  methods:{
    reload(){
      axios.get('/api/posts').then(res=>{
      this.posts = res.data;
    })
    },
    newPost() {
      if(!this.posts[0].isNew){
        this.posts.unshift({
          editMode: true,
          isNew: true,
        });
      }
    }
  }
}
</script>