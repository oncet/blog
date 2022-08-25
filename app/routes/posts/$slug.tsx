import type { LoaderFunction, MetaFunction } from "@remix-run/node";
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

export const meta: MetaFunction = ({ data }) => {
  return {
    title: data.title,
  };
};

export default function Slug() {
  const { title, body, category, image, publishedAt } =
    useLoaderData<PostWithCategory>();

  const createMarkup = () => {
    return { __html: body };
  };

  return (
    <>
      <h1>{title}</h1>
      <p className="text-slate-500">
        {format(new Date(publishedAt), "dd/MM/yyyy")}
      </p>
      <img src={image} alt={title} />
      <div
        className="flex flex-col gap-4"
        dangerouslySetInnerHTML={createMarkup()}
      />
      {!!category && (
        <p className="mb-4 text-right">
          <Link
            className="bg-slate-800 py-1 px-2"
            to={"/category/" + category.slug}
          >
            {category.name}
          </Link>
        </p>
      )}
    </>
  );
}
