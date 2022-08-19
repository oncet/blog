import type { LoaderFunction } from "@remix-run/node";
import { json } from "@remix-run/node";
import { useLoaderData } from "@remix-run/react";
import type { Post } from "@prisma/client";
import { marked } from "marked";

import { db } from "~/utils/db.server";

export const loader: LoaderFunction = async ({ params }) => {
  const post = await db.post.findFirst({
    where: {
      slug: params.slug,
    },
  });

  if (!post) {
    throw new Response("Post not found", {
      status: 404,
    });
  }

  return json({
    ...post,
    body: marked(post.body),
  });
};

export default function Slug() {
  const { title, body } = useLoaderData<Post>();

  const createMarkup = () => {
    return { __html: body };
  };

  return (
    <>
      <h1>{title}</h1>
      <div
        className="flex flex-col gap-4"
        dangerouslySetInnerHTML={createMarkup()}
      />
    </>
  );
}
