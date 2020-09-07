<template>
  <v-card
    class="friend mt-2 mx-2 px-3 pt-3"
    color="#D94848"
    height="92"
    width="221"
    outlined
    dark
    rounded="true"
  >
    <img :src="picture" v-if="picture.startsWith('https')" width="50" height="50" />
    <img
      :src="'http://localhost:8000/storage/'+picture"
      v-else
      alt="friend image"
      width="50"
      height="50"
    />
    <div class="friend-details ml-3">
      <a href="#">{{name}}</a>
      <a href="#" @click.prevent="sendToParent(id)">unfriend</a>
    </div>
  </v-card>
</template>
<style  scoped>
.friend {
  display: flex;
  flex-direction: row;
}

.friend-details {
  display: flex;
  flex-direction: column;
}

.friend-details a {
  color: #F2ADA7;
  font-weight: 900;
  font-size: 1rem;
}
</style>
<script>
export default {
    props:['picture','name','id'],
    methods:{
  sendToParent(id){
    console.log(id);
    this.$emit('unfriendId',id);
  }
}
    
}


</script>