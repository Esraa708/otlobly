<template>
  <div class="container">
    <h1>Groups</h1>
    <form action class="row mb-5">
      <div class="col-md-2">
        <label for="grp" class="mail-label pr-0 ml-4">Group</label>
      </div>
      <div class="col-md-8">
        <input
          type="text"
          name="grp"
          id="grp"
          class="form-control"
          placeholder="Please Enter grpup name"
          aria-describedby="helpId"
          v-model="grpName"
        />
      </div>
      <div class="col-md-2">
        <button type="sumbit" class="btn sumbit-btn" @click.prevent="addGroup()">Add</button>
      </div>
    </form>
    <div class="row">
      <div class="col-md-4">
        <p class="pars">My groups</p>
        <div class="user-groups">
          <div class="single-group mt-2" v-for="group in myGroups" :key="group.id">
            <a href="#" class="px-md-3 py-md-5">
              <p>{{group.name}}</p>
            </a>
            <div class="icons">
              <span class="d-block pr-md-3" @click="selectGrp(group)">
                <i class="fas fa-user-plus"></i>
              </span>
              <span class="d-block pl-md-2" @click="deleteGrp(group.id)">
                <i class="fas fa-times"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-8" v-if="selected">
        <p class="pars">{{currentGrp}}</p>
        <div class="friend">
          <form action class="row mb-1 mb-md-0">
            <div class="col-md-3">
              <label for="mail" class="mail-label pr-0 ml-2">Your friend name</label>
            </div>
            <div class="col-md-6">
              <input
                type="email"
                name="email"
                id="mail"
                class="form-control"
                placeholder="Please Enter a valid name"
                aria-describedby="helpId"
                v-model="friendName"
              />
            </div>
            <div class="col-md-3">
              <button type="sumbit" class="btn sumbit-btn" @click.prevent="addFriendToGroup()">Add</button>
            </div>
          </form>
          <div class="row">
            <div class="list">
              <single-friend
                v-for="friend in friends"
                :key="friend.id"
                :name="friend.name"
                :picture="friend.picture"
                :id="friend.id"
                @unfriendId="unfriend"
              ></single-friend>
            </div>
          </div>
        </div>
      </div>
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
h1 {
  color: #f28157;
}
.mail-label {
  color: #4e4873;
  font-size: 1.3rem;
  font-weight: bold;
}
.sumbit-btn {
  background: #d94848;
  padding: 6px 40px;
  color: #f2ada7;
}
.pars {
  font-size: 1.5rem;
  font-weight: 900;
  color: #f28157;
}
.user-groups {
  width: 100%;
  height: 300px;
  border: 3px solid #d94848;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}
.single-group {
  width: 90%;
  border: 1px solid #d94848;
  height: 50px;
  display: flex;
  flex-direction: row;
  justify-content: space-around;
  align-items: center;
}
.single-group a {
  flex: 2;
  font-size: 1.3rem;
  font-weight: bold;
  color: #4e4873;
}
.single-group a:hover {
  text-decoration: none;
}
.icons {
  display: flex;
  flex-direction: row;
  flex: 1;
}

.icons span {
  font-size: 1.4rem;
}
.icons span:hover {
  cursor: pointer;
}
.icons span:first-of-type {
  color: #4e4873;
}
.icons span:nth-child(2) {
  color: red;
}
.friend {
  width: 100%;
  height: 300px;
  border: 3px solid #d94848;
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
  /* border: 1px solid #f28157; */
  padding: 20px 30px;
}
</style>

<script>
export default {
  mounted() {
    console.log("Component mounted.");
    this.getMyGroups();
  },
  data() {
    return {
      grpName: null,
      currentGrp: null,
      groupId: null,
      friendName: null,
      color: "",
      mode: "success",
      snackbar: false,
      text: "",
      timeout: 6000,
      x: null,
      y: "top",
      myGroups: [],
      friends: [],
      selected: false,
    };
  },
  methods: {
    addGroup() {
      const group = {
        name: this.grpName,
      };
      axios
        .post("/groups", group)
        .then((res) => {
          console.log(res);
          this.getMyGroups();
          this.color = "#2E7D32";
          this.text = res.data;
          this.snackbar = true;
        })
        .catch((err) => {
          console.log(err.response.data.message);
          this.color = "#C62828";
          this.text = err.response.data.message;

          this.snackbar = true;
        });
    },
    getMyGroups() {
      axios
        .get("/groups")
        .then((res) => {
          console.log(res.data.groups);
          this.myGroups = res.data.groups;
        })
        .catch((err) => {
          console.log(err.response);
        });
    },
    selectGrp(group) {
      this.currentGrp = group.name;
      this.groupId = group.id;
      this.selected = true;
      this.bringGroupriends(this.groupId);
    },
    addFriendToGroup() {
      axios
        .post("/addfriendtogroup", {
          friendName: this.friendName,
          id: this.groupId,
        })
        .then((res) => {
          this.color = "#2E7D32";
          this.text = res.data;
          this.snackbar = true;
          this.bringGroupriends(this.groupId);
        })
        .catch((err) => {
          console.log(err.response.data.message);
          this.color = "#C62828";
          this.text = err.response.data.message;

          this.snackbar = true;
        });
    },
    bringGroupriends(id) {
      axios
        .get("/getGroupFriends/" + id)
        .then((res) => {
          console.log(res);
          this.friends = res.data.friends;
        })
        .catch((err) => {
          console.log(err.response);
        });
    },
    deleteGrp(id) {
      axios
        .delete("/groups/" + id)
        .then((res) => {
          console.log(res);
          this.getMyGroups();
        })
        .catch((err) => {
          console.log(err.response);
        });
    },
    unfriend(unfriendId) {
      console.log(unfriendId);
      axios
        .delete("/friends/" + unfriendId)
        .then((res) => {
          console.log(res);
          this.bringGroupriends(this.groupId);
        })
        .catch((err) => {
          console.log(err.response);
        });
    },
  },
};
</script>
