import type { LoaderFunction } from "@remix-run/node";
import { json } from "@remix-run/node";
import { Link, useLoaderData } from "@remix-run/react";
import type { Prisma } from "@prisma/client";

import { db } from "~/utils/db.server";

type CategoryWithPosts = Prisma.CategoryGetPayload<{
  include: {
    posts: true;
  };
}>;

export const loader: LoaderFunction = async ({ params }) => {
  const category = await db.category.findFirst({
    where: {
      slug: params.slug,
    },
    include: {
      posts: true,
    },
  });

  if (!category) {
    throw new Response("Category not found", {
      status: 404,
    });
  }

  return json(category);
};

export default function Category() {
  const { name, posts } = useLoaderData<CategoryWithPosts>();

  return (
    <>
      <h1>{name}</h1>
      {posts && (
        <ul>
          {posts.map((post) => (
            <li key={post.id}>
              <Link to={"/posts/" + post.slug}>{post.title}</Link>
            </li>
          ))}
        </ul>
      )}
    </>
  );
}
