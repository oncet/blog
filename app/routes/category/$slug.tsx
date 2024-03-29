import type { LoaderFunction, MetaFunction } from "@remix-run/node";
import { json } from "@remix-run/node";
import { Link, useLoaderData } from "@remix-run/react";
import type { Prisma } from "@prisma/client";

import { db } from "~/utils/db.server";
import PostCard from "~/components/PostCard";

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

export const meta: MetaFunction = ({ data }) => {
  return {
    title: (data ? data.name : "Category not found") + " - Oncet",
  };
};

export default function Category() {
  const { name, posts } = useLoaderData<CategoryWithPosts>();

  return (
    <>
      <h1>{name}</h1>
      <p>Latests blog posts categorized under {name}.</p>
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
