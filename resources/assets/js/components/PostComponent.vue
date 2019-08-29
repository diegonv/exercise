<template>
  <div>
    <span class="badge badge-primary float-right" v-if="!post.isNew">
      {{post.updated_at}}
    </span>
    <div v-if="!this.editMode">
      <h2>{{post.title}}</h2>
      <h3 v-if="post.subtitle.length>=maxSubtitleLeng">
        {{post.subtitle.substring(0,maxSubtitleLeng,)+"..."}}
      </h3>
      <h3 v-else>{{post.subtitle}}</h3>
      <p>{{post.content}}</p>
    </div>
    <div v-else>
      <form @submit.prevent>
        <input type="text" class="form-control mb-2" 
          v-model="post.title" />
        <input type="text" class="form-control mb-2" 
          v-model="post.subtitle" />
        <textarea rows="20" class="form-control mb-2" 
          v-model="post.content" />
          <div class="text-right">
            <button class="btn btn-warning" @click="savePost()" >Ok</button>
            <button class="btn btn-danger" @click="cancel()">Cancelar</button>
          </div>
      </form>
    </div>
    <div class="text-right" v-if="editable && !this.editMode">
      <button class="btn btn-warning btn-sm" 
          @click="toggleEdit()">Editar</button>
      <button class="btn btn-danger btn-sm" 
          @click="deletePost()">Eliminar</button>
    </div>
    <hr />
  </div>
</template>

<script>
export default {
  props: {
    post: Object,
    editable: Boolean,
  },
  data() {
    return {
      maxSubtitleLeng: process.env.MIX_MAX_SUBTITLE_LENG,
      editMode: this.post.editMode || false,
      isNew: this.post.isNew || false
    }
  },
  methods:{
    toggleEdit() {
      if (!this.editMode){
        this.postBeforeEdit = {...this.post};
      }
      this.editMode = !this.editMode;
    },
    savePost(){
      if(this.post.title === undefined || this.post.subtitle === undefined || this.post.content === undefined
        || this.post.title.trim() === '' || this.post.subtitle.trim() === '' || this.post.content.trim() === '' ){
        alert('All fields are required');
        return;
      }
      if(this.post.isNew) {
        axios.post('/api/posts', this.post)
        .then((res) =>{
          this.post.isNew = false;
          this.post.editMode = false;
          this.$emit('reload')
        });
      } else {
        axios.put(`/api/posts/${this.post._id}`, this.post)
        .then(res=>{
          this.toggleEdit();
        });
      }
      
    },
    cancel() {
      if(this.post.isNew) {
        this.$emit('reload');
      }else{
        this.toggleEdit();
        Object.assign(this.post, this.postBeforeEdit);
      }
    },
    deletePost() {
      if(confirm(`Delete post: ${this.post.title}`)){
        axios.delete(`/api/posts/${this.post._id}`)
          .then(()=>{
            this.$emit('reload')
          })
      }
    },
  }
}
</script>