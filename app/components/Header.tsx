import { Link } from "@remix-run/react";

const Header = () => {
  return (
    <header className="border-b border-gray-800 px-5 py-2">
      <div>
        <Link className="font-bold" to="/">
          Oncet's blog
        </Link>
      </div>
    </header>
  );
};

export default Header;
