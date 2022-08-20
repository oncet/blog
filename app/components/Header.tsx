import { Link } from "@remix-run/react";

const Header = () => {
  return (
    <header>
      <div>
        <Link className="font-bold" to="/">
          Oncet's blog
        </Link>
      </div>
    </header>
  );
};

export default Header;
