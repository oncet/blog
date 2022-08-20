import type { LoaderFunction } from "@remix-run/node";
import { json } from "@remix-run/node";
import { Link, useLoaderData } from "@remix-run/react";
import type { Prisma } from "@prisma/client";
import { format } from "date-fns";
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
      publishedAt: {
        not: undefined,
      },
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

  return json({
    ...post,
    body: marked(post.body),
  });
};

export default function Slug() {
  const { title, body, category, publishedAt } =
    useLoaderData<PostWithCategory>();

  const createMarkup = () => {
    return { __html: body };
  };

  return (
    <>
      <div>
        <p className="text-slate-500">
          {format(new Date(publishedAt), "dd/MM/yyyy")}
        </p>
        {!!category && (
          <p>
            <Link to={"/category/" + category.slug}>{category.name}</Link>
          </p>
        )}
        <h1>{title}</h1>
      </div>
      <div
        className="flex flex-col gap-4"
        dangerouslySetInnerHTML={createMarkup()}
      />
    </>
  );
}
