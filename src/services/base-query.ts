// import variable fetchbasequery dari redux toolkit untuk consume API
import { fetchBaseQuery } from "@reduxjs/toolkit/query";
import { createApi } from "@reduxjs/toolkit/query/react";

// narik baseQuery atau base env
const baseQuery = fetchBaseQuery({
  //   menyiapkan baseUrl dari env next
  baseUrl: process.env.NEXT_PUBLIC_API_BASE_URL,
  //   menyiapkan headers
  prepareHeaders: async (headers) => {
    headers.set("Accept", "application/json");
    return headers;
  },
});

export const apiSlice = createApi({
  reducerPath: "api",
  baseQuery: baseQuery,
  endpoints: () => ({}),
});
