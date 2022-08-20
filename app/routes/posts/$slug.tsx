import type { LoaderFunction } from "@remix-run/node";
import { json } from "@remix-run/node";
import { Link, useLoaderData } from "@remix-run/react";
import type { Prisma } from "@prisma/client";
import { marked } from "marked";

import { db } from "~/utils/db.server";

type PostWithCategory = Prisma.PostGetPayload<{
  include: {
    category: true;
  };
}>;

export const loader: LoaderFunction = async ({ params }) => {
  const post = await db.post.findFirst({
    where: {
      slug: params.slug,
    },
    include: {
      category: true,
    },
  });

  if (!post) {
    throw new Response("Post not found", {
      status: 404,
    });
  }

  console.log(post);

  return json({
    ...post,
    body: marked(post.body),
  });
};

export default function Slug() {
  const { title, body, category } = useLoaderData<PostWithCategory>();

  const createMarkup = () => {
    return { __html: body };
  };

  return (
    <>
      {!!category && (
        <p>
          <Link to={"/category/" + category.slug}>{category.name}</Link>
        </p>
      )}
      <h1>{title}</h1>
      <div
        className="flex flex-col gap-4"
        dangerouslySetInnerHTML={createMarkup()}
      />
    </>
  );
}
