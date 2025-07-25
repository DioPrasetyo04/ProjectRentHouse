"use client";
import { store } from "@/lib/store";
import { Provider } from "react-redux";
import { SessionProvider } from "next-auth/react";

// membuat template redux provider untuk consume API Laravel
function ReduxProvider({ children }: { children: React.ReactNode }) {
  return (
    <SessionProvider>
      <Provider store={store}>{children}</Provider>;
    </SessionProvider>
  );
}

export default ReduxProvider;
