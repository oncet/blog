import type { LoaderFunction } from "@remix-run/node";
import { json } from "@remix-run/node";
import { useLoaderData, Link } from "@remix-run/react";
import type { Post } from "@prisma/client";

import { db } from "~/utils/db.server";
import PostCard from "~/components/PostCard";

type LoaderData = { posts: Array<Post> };

export const loader: LoaderFunction = async () => {
  const data = {
    posts: await db.post.findMany({
      where: {
        publishedAt: {
          not: undefined,
        },
      },
    }),
  };

  return json(data);
};

export default function Index() {
  const { posts } = useLoaderData<LoaderData>();

  return (
    <>
      <h1>Oncet's blog</h1>
      {posts && (
        <ul className="list-none">
          {posts.map((post) => (
            <li key={post.id}>
              <Link
                to={"post/" + post.slug}
                className="flex flex-col gap-4 hover:no-underline"
              >
                <PostCard post={post} />
              </Link>
            </li>
          ))}
        </ul>
      )}
    </>
  );
}
