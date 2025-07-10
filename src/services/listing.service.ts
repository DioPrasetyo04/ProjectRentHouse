import { apiSlice } from "./base-query";

export const listingApi = apiSlice.injectEndpoints({
  endpoints: (builder) => ({
    getAllListing: builder.query({
      query: () => ({
        url: "/listings",
        method: "GET",
      }),
    }),
    getListingById: builder.query({
      query: (slug: string) => ({
        url: `/listings/${slug}`,
        method: "GET",
      }),
    }),
  }),
});

export const { useGetAllListingQuery, useGetListingByIdQuery } = listingApi;
