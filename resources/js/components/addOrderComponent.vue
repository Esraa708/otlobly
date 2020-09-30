<template>
  <v-app>
    <v-container fluid>
      <v-form enctype="multipart/form-data">
        <v-row align="center">
          <v-col class="d-flex" cols="12" sm="6" md="3">
            <v-select
              v-model="meal"
              :items="meals"
              item-text="name"
              item-value="id"
              label="Choose meal"
              solo
            ></v-select>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" sm="6" md="3">
            <v-text-field label="From" v-model="from" solo></v-text-field>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" sm="6" md="3">
            <v-autocomplete
              v-model="friends"
              :items="friendsNoGroup"
              item-text="name"
              dense
              chips
              small-chips
              label="Friends"
              multiple
              solo
              item-value="id"
            ></v-autocomplete>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" sm="6" md="3">
            <v-autocomplete
              v-model="groups"
              :items="userGrps"
              item-text="name"
              dense
              chips
              small-chips
              label="Groups"
              multiple
              solo
              item-value="id"
            ></v-autocomplete>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" sm="6" md="3">
            <v-file-input
              label="Upload menu image"
              v-model="image"
              show-size
              counter
              solo
              dense
              appened-icon="fa-upload"
            ></v-file-input>
          </v-col>
        </v-row>
        <div class="my-2">
          <v-btn
            color="#d94848"
            x-large
            light
            class="white--text"
            type="sumbit"
            @click.prevent="sendOrder"
            >Send order</v-btn
          >
        </div>
      </v-form>
    </v-container>
  </v-app>
</template>
<style  scoped>
</style>

<script>
</script>
<script>
export default {
  created() {
    console.log("mounted");
    this.bringMeals();
    this.friendsNoGrp();
    this.allGrps();
        this.getUser();
  },
  mounted() {

    console.log(this.user);
    // var pusher = new Pusher("3924e1b484fe7c4770fa", {
    //   cluster: "us2",
    // });
    // var channel = pusher.subscribe("order");
    // channel.bind("createOrder", function (data) {
    //   // app.messages.push(JSON.stringify(data));
    //   alert(JSON.stringify(data));
    // });
    Echo.channel('order'+this.user.id)
    .listen('createOrder', (e) => {
        alert(e)
    });
  },

  data() {
    return {
      meals: [],
      meal: "",
      values: ["foo", "bar"],
      friendsNoGroup: [],
      friends: [],
      userGrps: [],
      groups: [],
      from: null,
      image: null,
      messages: [],
      user:null
    };
  },
  methods: {
    bringMeals() {
      axios
        .get("/meals")
        .then((res) => {
          this.meals = res.data.meals;
        })
        .catch((err) => {
          console.log(err.data);
        });
    },
    friendsNoGrp() {
      axios
        .get("/friendsnogropus")
        .then((res) => {
          console.log(res);
          this.friendsNoGroup = res.data.friendsNoGroup;
        })
        .catch((err) => {
          console.log(err.data);
        });
    },
    allGrps() {
      axios
        .get("/groups")
        .then((res) => {
          console.log(res);
          this.userGrps = res.data.groups;
        })
        .catch((err) => {
          console.log(err.data);
        });
    },
    uploadFile(e) {
      let file = e.target.files[0];
      let reader = new FileReader();

      if (file["size"] < 2111775) {
        reader.onloadend = (file) => {
          //console.log('RESULT', reader.result)
          this.image = reader.result;
        };
        reader.readAsDataURL(file);
      } else {
        alert("File size can not be bigger than 2 MB");
      }
    },
    getUser(){
           axios
        .get("/user")
        .then((res) => {
          console.log(res);
          this.user = res.data.user;
        })
        .catch((err) => {
          console.log(err.data);
        });

    },
    sendOrder() {
      console.log(this.image);
      let formData = new FormData();
      formData.append("photo", this.image);
      formData.append("meal", this.meal);
      formData.append("from", this.from);
      formData.append("friends", this.friends);
      formData.append("groups", this.groups);
      formData.append("status", "waiting");

      axios
        .post("/orders", formData)
        .then((res) => {
          console.log(res);
          // this.userGrps = res.data.groups;
        })
        .catch((err) => {
          console.log(err.data);
        });
    },
  },
};
</script>