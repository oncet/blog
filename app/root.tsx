import type { MetaFunction } from "@remix-run/node";
import {
  Links,
  LiveReload,
  Meta,
  Outlet,
  Scripts,
  ScrollRestoration,
  useCatch,
} from "@remix-run/react";

import styles from "~/styles/app.css";
import Header from "~/components/Header";
import Layout from "~/components/Layout";

export function links() {
  return [{ rel: "stylesheet", href: styles }];
}

export const meta: MetaFunction = () => {
  return {
    charset: "utf-8",
    title: "Awesome blog",
    viewport: "width=device-width,initial-scale=1",
  };
};

export function CatchBoundary() {
  const caught = useCatch();

  return (
    // TODO Change meta title depending on caught data
    <Layout>
      <div className="flex flex-col gap-4">
        <h1>Whoops!</h1>
        <p>{caught.data || "Not found, sorry."}</p>
      </div>
    </Layout>
  );
}

export default function App() {
  return (
    <Layout>
      <Outlet />
      <ScrollRestoration />
      <Scripts />
      <LiveReload />
    </Layout>
  );
}
