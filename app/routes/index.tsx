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
    <>
      <h1>Oncet's blog</h1>
      {posts && (
        <ul className="list-disc list-inside px-2">
          {posts.map((post) => (
            <li key={post.id}>
              <Link to={"posts/" + post.slug}>{post.title}</Link>
            </li>
          ))}
        </ul>
      )}
    </>
  );
}
