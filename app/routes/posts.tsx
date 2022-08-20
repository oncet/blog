import { Link, Outlet } from "@remix-run/react";

export default function Index() {
  return (
    <>
      <header>
        <div>
          <Link to="/">Oncet's blog</Link>
        </div>
      </header>
      <Outlet />
    </>
  );
}
