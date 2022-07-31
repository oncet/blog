import { json } from "@remix-run/node";
import { useLoaderData, Link } from "@remix-run/react";
import type { Post } from "@prisma/client";

import { db } from "~/utils/db.server";

type LoaderData = { posts: Array<Post> };

export const loader = async () => {
  const data = {
    posts: await db.post.findMany(),
  };

  return json(data);
};

export default function Index() {
  const { posts } = useLoaderData<LoaderData>();

  return (
    <div>
      <h1>Blog</h1>
      {posts && (
        <ul>
          {posts.map((post) => (
            <li key={post.id}>
              <Link to={post.slug}>{post.title}</Link>
            </li>
          ))}
        </ul>
      )}
    </div>
  );
}
