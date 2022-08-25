import { Meta, Links } from "@remix-run/react";

import Header from "~/components/Header";

const Layout: React.FC = ({ children }) => {
  return (
    <html lang="en" className="dark">
      <head>
        <Meta />
        <Links />
      </head>
      <body className="min-h-screen flex flex-col bg-white text-black dark:bg-black dark:text-white">
        <Header />
        <main className="px-5 flex flex-col gap-4 grow mx-auto max-w-screen-md">
          {children}
        </main>
        <footer className="px-5 py-2 bg-gray-800">
          <div className="mx-auto max-w-screen-md">
            <a href="https://github.com/oncet/blog">oncet/blog</a>
          </div>
        </footer>
      </body>
    </html>
  );
};

export default Layout;
