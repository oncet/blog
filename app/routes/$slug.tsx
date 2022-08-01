import type { LoaderFunction } from "@remix-run/node";
import { json } from "@remix-run/node";
import { useCatch, useLoaderData } from "@remix-run/react";
import type { Post } from "@prisma/client";

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

  return json(post);
};

export default function Slug() {
  const { title, body } = useLoaderData<Post>();

  return (
    <>
      <h1>{title}</h1>
      {body}
    </>
  );
}
