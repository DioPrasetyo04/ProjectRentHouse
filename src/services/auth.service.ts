import { apiSlice } from "./base-query";

export const authApi = apiSlice.injectEndpoints({
  endpoints: (builder) => ({
    login: builder.mutation({
      query: (credentials) => ({
        // endpoint url
        url: "/login",
        // method
        method: "POST",
        // body values
        body: credentials,
      }),
    }),
    register: builder.mutation({
      query: (credentials) => ({
        // endpoint url
        url: "/register",
        // method
        method: "POST",
        // body values
        body: credentials,
      }),
    }),
  }),
});

// Ini WAJIB agar useLoginMutation tersedia
// install dependenciesnpm install @reduxjs/toolkit react-redux
export const { useLoginMutation, useRegisterMutation } = authApi;
