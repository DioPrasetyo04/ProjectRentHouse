// deklrasi extend typescript type tipe data bawaan NextAuth
import NextAuth from "next-auth/next";

declare module "next-auth" {
  interface Session {
    // dalam session menambahkan id dan token pada user yang autentikasi
    user: {
      id: number;
      token: string;
    } & DefaultSession["user"];
  }

  interface User {
    // dalam user menambahkan token dengan tipe data string pada session
    token: string;
  }
}
