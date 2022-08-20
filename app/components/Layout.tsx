import { Meta, Links } from "@remix-run/react";

import Header from "~/components/Header";

const Layout: React.FC = ({ children }) => {
  return (
    <html lang="en" className="dark">
      <head>
        <Meta />
        <Links />
      </head>
      <body className="mx-auto max-w-screen-md min-h-screen flex flex-col bg-white text-black dark:bg-black dark:text-white">
        <Header />
        <main className="px-5 py-2 flex flex-col gap-4 grow">{children}</main>
        <footer className="px-5 py-2 text-right">
          <a href="https://github.com/oncet/blog">GitHub</a>
        </footer>
      </body>
    </html>
  );
};

export default Layout;
