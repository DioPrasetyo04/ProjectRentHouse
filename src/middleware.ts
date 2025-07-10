export { default } from "next-auth/middleware";

// mengatur konfigurasi page yang butuh autentikasi login next auth untuk beberapa pages agar tidak bisa booking karena butuh autentikasi
export const config = {
  matcher: ["/listing/:id/checkout", "/booking-success/:path*", "/dashboard"],
};
