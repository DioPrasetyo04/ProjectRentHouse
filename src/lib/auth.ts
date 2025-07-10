import { AuthOptions } from "next-auth";
import Credentials from "next-auth/providers/credentials";

export const authOptions: AuthOptions = {
  session: {
    // jwt singkatan dari json web token karena kita menggunakan laravel sanctum yang dikirim tokennya lewat json
    // menandakan bahwa session autentikasi menggunakan JWT untuk strategi penyimpanan sesi auth bukan berbasis session yang disimpan database
    strategy: "jwt",
    maxAge: 60 * 60 * 24, // 1 day
  },

  // pages yang digunakan adalah page SignIn untuk jwt
  pages: {
    signIn: "/sign-in",
  },

  // credential yang digunakan berupa id, email, name, token untuk data autentikasi
  // metode yang digunakan untuk autentikasi
  providers: [
    Credentials({
      credentials: {
        id: {
          type: "number",
        },
        email: {
          type: "text",
        },
        name: {
          type: "text",
        },
        token: {
          type: "text",
        },
      },
      // mengauthorize kredensial untuk proses autentikasi seperti bearer token dalam autentikasi sanctum yang ada credentialnya
      authorize: async (credentials, req) => {
        return credentials || null;
      },
    }),
  ],

  // mengatur callback untuk jwt
  callbacks: {
    // callback jwt digunakan untuk menambahkan data user kedalam token JWT saat login jadi penyimpanan sesi bukan penyimpanan server database
    jwt: async ({ user, token }) => {
      // jika ada user simpan id token dan tokennya
      if (user) {
        token.id = +user.id;
        token.token = user.token;
      }
      // mengembalikan nilai token
      return token;
    },

    // mengambil data user dari JWT dan memasukkannya kedalam session yang bisa diakses oleh frontend
    session: async ({ session, token }) => {
      // jika ada session user
      if (session?.user) {
        session.user.id = token.id as number;
        session.user.token = token.token as number;
      }
      // tampilkan session user
      return session;
    },
  },
};
