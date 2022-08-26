import type { LoaderFunction, MetaFunction } from "@remix-run/node";
import { json } from "@remix-run/node";
import { Link, useLoaderData } from "@remix-run/react";
import type { Prisma } from "@prisma/client";
import { format } from "date-fns";

import { db } from "~/utils/db.server";

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
                <h2>{post.title}</h2>
                <p className="text-slate-500">
                  {format(new Date(post.publishedAt), "dd/MM/yyyy")}
                </p>
                <img src={post.image} alt={post.title} />
              </Link>
            </li>
          ))}
        </ul>
      )}
    </>
  );
}
