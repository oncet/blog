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

import styles from "./styles/app.css";

export function links() {
  return [{ rel: "stylesheet", href: styles }];
}

export const meta: MetaFunction = () => {
  return {
    charset: "utf-8",
    title: "New Remix App",
    viewport: "width=device-width,initial-scale=1",
  };
};

export function CatchBoundary() {
  const caught = useCatch();

  return (
    <html lang="en">
      <head>
        {/* TODO Don't know how to overwrite <Meta /> title */}
        <meta charSet="utf-8" />
        <title>{caught.data}</title>
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <Links />
      </head>
      <body>
        <div>
          <h1>{caught.data}</h1>
          <p>Whoops! Sorry.</p>
        </div>
      </body>
    </html>
  );
}

export default function App() {
  return (
    <html lang="en" className="dark">
      <head>
        <Meta />
        <Links />
      </head>
      <body className="px-5 py-2 flex flex-col gap-4 bg-white text-black dark:bg-black dark:text-white">
        <Outlet />
        <ScrollRestoration />
        <Scripts />
        <LiveReload />
      </body>
    </html>
  );
}
