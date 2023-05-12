export default {
    getAuthUser() {
      return JSON.parse(localStorage.getItem("user"));
    },
    initializeAuthUser(user) {
      // To be implemented
      localStorage.setItem("user", user);
    },
    clearAuthUser() {
      localStorage.removeItem("user");
    },
  };
