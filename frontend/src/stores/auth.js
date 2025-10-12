import { defineStore } from "pinia";
import axios from "axios"; // We'll replace this later with our own instance

export const useAuthStore = defineStore("auth", {
  state: () => ({
    user: JSON.parse(localStorage.getItem("user")),
    token: localStorage.getItem("token"),
  }),
  getters: {
    isAuthenticated: (state) => !!state.token,
    user: (state) => state.user,
  },
  actions: {
    async login(email, password) {
      try {
        const response = await axios.post("http://127.0.0.1:8000/api/login", {
          email: email,
          password: password,
        });

        const { user, token } = response.data;

        // Update state
        this.user = user;
        this.token = token;

        // Store in local storage for persistence
        localStorage.setItem("user", JSON.stringify(user));
        localStorage.setItem("token", token);

        return true; // Indicate success
      } catch (error) {
        console.error("Login failed:", error);
        return false; // Indicate failure
      }
    },
    logout() {
      // Clear state
      this.user = null;
      this.token = null;

      // Clear from local storage
      localStorage.removeItem("user");
      localStorage.removeItem("token");
    },
  },
});
