import type { LoaderFunction, MetaFunction } from "@remix-run/node";
import { json } from "@remix-run/node";
import { Link, useLoaderData } from "@remix-run/react";
import type { Prisma } from "@prisma/client";

import { db } from "~/utils/db.server";
import PostCard from "~/components/PostCard";

type TagWithPosts = Prisma.TagGetPayload<{
  include: {
    posts: true;
  };
}>;

export const loader: LoaderFunction = async ({ params }) => {
  const tag = await db.tag.findFirst({
    where: {
      slug: params.slug,
    },
    include: {
      posts: true,
    },
  });

  if (!tag) {
    throw new Response("Tag not found", {
      status: 404,
    });
  }

  return json(tag);
};

export const meta: MetaFunction = ({ data }) => {
  return {
    title: data ? data.name : "Tag not found",
  };
};

export default function Tag() {
  const { name, posts } = useLoaderData<TagWithPosts>();

  return (
    <>
      <h1>{name}</h1>
      {posts && (
        <ul className="list-none">
          {posts.map((post) => (
            <li key={post.id}>
              <Link
                to={"/post/" + post.slug}
                className="flex flex-col gap-4 hover:no-underline"
              >
                <PostCard
                  post={{
                    ...post,
                    publishedAt: new Date(post.publishedAt),
                    createdAt: new Date(post.createdAt),
                  }}
                />
              </Link>
            </li>
          ))}
        </ul>
      )}
    </>
  );
}
