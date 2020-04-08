<template>
  <div class="flex flex-col items-center" v-if="status.user === 'success' && user">
    <div class="relative mb-10">
      <div class="w-100 h-64 overflow-hidden z-10">
        <img
          src="https://cdn.photographylife.com/wp-content/uploads/2017/01/What-is-landscape-photography.jpg"
          class="object-cover w-full"
          alt="user background image"
        />
      </div>
      <div class="absolute flex items-center bottom-0 left-0 -mb-8 ml-6 z-20">
        <div class="w-32">
          <img
            src="https://avatars1.githubusercontent.com/u/34833028?s=460&u=50ce853588a02653cc889335df998ce0d6ace7d6&v=4"
            alt="user profile image"
            class="w-32 h-32 border-4 border-gray-200 rounded-full shadow-lg object-cover"
          />
        </div>
        <p class="text-2xl text-gray-100 ml-4">{{ user.data.attributes.name }}</p>
      </div>

      <div class="absolute flex items-center bottom-0 right-0 mb-4 mr-12 z-20">
        <button
          v-if="friendButtonText && friendButtonText !== 'Accept'"
          class="py-1 px-3 bg-gray-300 rounded"
          @click="$store.dispatch('sendFriendRequest', $route.params.userId)"
        >{{ friendButtonText }}</button>
        <button
          v-if="friendButtonText && friendButtonText === 'Accept'"
          class="mr-2 py-1 px-3 bg-blue-300 rounded"
          @click="$store.dispatch('acceptFriendRequest', $route.params.userId)"
        >Accept</button>
        <button
          v-if="friendButtonText && friendButtonText === 'Accept'"
          class="py-1 px-3 bg-gray-300 rounded"
          @click="$store.dispatch('ignoreFriendRequest', $route.params.userId)"
        >Ignore</button>
      </div>
    </div>

    <div v-if="status.posts === 'loading'">Loading posts...</div>
    <div v-else-if="posts.length < 1">No posts found.</div>
    <Post v-else v-for="(post, postKey) in posts.data" :post="post" :key="postKey" />
  </div>
</template>

<script>
import Post from "../../components/Post";
import { mapGetters } from "vuex";

export default {
  name: "Show",
  components: {
    Post
  },
  mounted() {
    this.$store.dispatch("fetchUser", this.$route.params.userId);
    this.$store.dispatch("fetchUserPosts", this.$route.params.userId);
  },

  computed: {
    ...mapGetters({
      user: "user",
      posts: "posts",
      status: "status",
      friendButtonText: "friendButtonText"
    })
  }
};
</script>
