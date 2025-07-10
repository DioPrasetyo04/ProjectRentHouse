import { configureStore } from "@reduxjs/toolkit";
import { apiSlice } from "@/services/base-query";
import { setupListeners } from "@reduxjs/toolkit/query";

// fungsi untuk configurasi store atau kirim data pada aplikasi redux toolkit
export const store = configureStore({
  // reducer untuk mengubah nilai isi variabel
  reducer: {
    //   menyiapkan reducer dan reducerPath
    [apiSlice.reducerPath]: apiSlice.reducer,
  },

  //   menyiapkan middleware untuk apk slice
  middleware: (getDefaultMiddleware) =>
    getDefaultMiddleware().concat(apiSlice.middleware),
});

export type RootState = ReturnType<typeof store.getState>;
export type AppDispatch = typeof store.dispatch;

setupListeners(store.dispatch);
