import { Meta, Links, Link } from "@remix-run/react";

const Layout: React.FC = ({ children }) => {
  return (
    <html lang="en" className="dark">
      <head>
        <Meta />
        <Links />
      </head>
      <body className="px-5 py-2 flex flex-col gap-4 bg-white text-black dark:bg-black dark:text-white">
        <header>
          <div>
            <Link to="/">Oncet's blog</Link>
          </div>
        </header>
        {children}
      </body>
    </html>
  );
};

export default Layout;
