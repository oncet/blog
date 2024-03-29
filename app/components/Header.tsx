import { Link } from "@remix-run/react";

const Header = () => {
  return (
    <header className="border-b border-gray-800">
      <div className="mx-auto max-w-screen-md px-5 py-2">
        <Link className="font-bold" to="/">
          Oncet's blog
        </Link>
      </div>
    </header>
  );
};

export default Header;
