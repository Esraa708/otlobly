<template>
  <div class="container">
    <h1>Friends</h1>
    <form action class="row mb-5">
      <div class="col-md-2">
        <label for="mail" class="mail-label pr-0 ml-4">Friend Email</label>
      </div>
      <div class="col-md-8">
        <input
          type="email"
          name="email"
          id="mail"
          class="form-control"
          placeholder="Please Enter a valid email"
          aria-describedby="helpId"
          v-model="friendMail"
        />
      </div>
      <div class="col-md-2">
        <button type="sumbit" class="btn sumbit-btn" @click.prevent="addFriend()">Add</button>
      </div>
    </form>
    <h1>Friend list</h1>
    <div class="list">
        <v-card class="friend mt-2 mx-2 px-3 pt-3" color="#D94848" height="92" v-for="friend in friends" :key="friend.id" width="221" outlined dark rounded="true">
          <img
            :src="friend.picture"
            v-if="friend.picture.startsWith('https')"
            width="50"
            height="50"
          />
          <img
            :src="'http://localhost:8000/storage/'+ friend.picture"
            v-else
            alt="friend image"
            width="50"
            height="50"
          />
          <div class="friend-details ml-3">
            <a href="#">{{friend.name}}</a>
            <a href="#" @click.prevent="unfriend(friend.id)">unfriend</a>
          </div>
        </v-card>
    </div>
    <v-snackbar
      v-model="snackbar"
      :bottom="y === 'bottom'"
      :color="color"
      :left="x === 'left'"
      :multi-line="mode === 'multi-line'"
      :right="x === 'right'"
      :timeout="timeout"
      :top="y === 'top'"
      :vertical="mode === 'vertical'"
    >
      {{ text }}
      <template v-slot:action="{ attrs }">
        <v-btn dark text v-bind="attrs" @click="snackbar = false">Close</v-btn>
      </template>
    </v-snackbar>

  </div>
</template>
<style scoped>
h1{
  color: #F28157;
}
.mail-label{
  color:#4E4873;
  font-size: 1.3rem;
  font-weight: bold;

}
.sumbit-btn{
  background:#D94848;
  padding:6px 40px;
  color: #F2ADA7;
}
.list {
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  justify-content: flex-start;
  align-content: flex-start;
  width: 100%;
  min-height: 200px;
  overflow: auto;
  border: 1px solid #F28157;
  padding: 20px 30px;
}
.friend {
  display: flex;
  flex-direction: row;
}
.friend-details {
  display: flex;
  flex-direction: column;

}
.friend-details a{
  color:#F2ADA7;
  font-weight: 900;
  font-size: 1rem;
}
</style>

<script>
export default {
  mounted() {
    console.log("Component mounted.");
    this.getFriends();
  },
  data() {
    return {
      friendMail: null,
      color: "",
      mode: "success",
      snackbar: false,
      text: "",
      timeout: 6000,
      x: null,
      y: "top",
      friends: [],
    };
  },
  methods: {
    addFriend() {
      const email = {
        email: this.friendMail,
      };
      axios
        .post("/friends", email)
        .then((res) => {
          console.log(res);
          this.color = "#2E7D32";
          this.text = res.data;
          this.snackbar = true;
          this.friendMail = "";
          this.getFriends();
        })
        .catch((err) => {
          console.log(err.response.data.message);
          this.color = "#C62828";
          this.text = err.response.data.message;

          this.snackbar = true;
        });
    },
    getFriends() {
      axios
        .get("/friends")
        .then((res) => {
          console.log(res.data.friends);
          this.friends = res.data.friends;
        })
        .catch((err) => {
          console.log(err.response);
        });
    },
    unfriend(id) {
      axios
        .delete("/friends/" + id)
        .then((res) => {
          console.log(res);
          this.getFriends();
          // this.friends=res.data.friends;
        })
        .catch((err) => {
          console.log(err.response);
        });
    },
  },
};
</script>
