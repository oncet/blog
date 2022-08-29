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
    tags: true;
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
      tags: true,
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
    title: data ? data.title : "Post not found",
  };
};

export default function Slug() {
  const { title, image, imageAlt, body, category, tags, publishedAt } =
    useLoaderData<PostWithCategory>();

  const createMarkup = () => {
    return { __html: body };
  };

  return (
    <>
      <h1>{title}</h1>
      {!!category && (
        <p>
          <Link
            className="bg-slate-800 py-1 px-2 inline-block"
            to={"/category/" + category.slug}
          >
            {category.name}
          </Link>
        </p>
      )}
      <p className="text-slate-500">
        {format(new Date(publishedAt), "dd/MM/yyyy")}
      </p>
      {image && <img src={image} alt={imageAlt || title} />}
      <div
        className="flex flex-col gap-4"
        dangerouslySetInnerHTML={createMarkup()}
      />
      {!!tags && (
        <ul className="list-none flex flex-row justify-end">
          {tags.map((tag) => (
            <li key={tag.id}>
              <Link
                className="inline-block bg-slate-800 py-1 px-2"
                to={"/tag/" + tag.slug}
              >
                {tag.name}
              </Link>
            </li>
          ))}
        </ul>
      )}
    </>
  );
}
