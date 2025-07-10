"use client";
import { store } from "@/lib/store";
import { Provider } from "react-redux";

// membuat template redux provider untuk consume API Laravel
function ReduxProvider({ children }: { children: React.ReactNode }) {
  return <Provider store={store}>{children}</Provider>;
}

export default ReduxProvider;
