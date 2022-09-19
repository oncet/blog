import type { LoaderFunction, MetaFunction } from "@remix-run/node";
import { json } from "@remix-run/node";
import { Link, useLoaderData } from "@remix-run/react";
import type { Prisma } from "@prisma/client";
import { format } from "date-fns";
import { marked } from "marked";

import { db } from "~/utils/db.server";

type PostWithCategory = Prisma.PostGetPayload<{
  include: {
    categories: true;
    tags: true;
  };
}>;

export const loader: LoaderFunction = async ({ params }) => {
  const post = await db.post.findFirst({
    where: {
      slug: params.slug,
      published: true,
    },
    include: {
      categories: true,
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
  const { title, image, imageAlt, body, categories, tags, updatedAt } =
    useLoaderData<PostWithCategory>();

  const createMarkup = () => {
    return { __html: body };
  };

  return (
    <>
      <h1>{title}</h1>
      {!!categories && (
        <ul className="list-none flex flex-row">
          {categories.map((category) => (
            <li key={category.id}>
              <Link
                className="inline-block bg-slate-800 py-1 px-2"
                to={"/category/" + category.slug}
              >
                {category.name}
              </Link>
            </li>
          ))}
        </ul>
      )}
      <p className="text-slate-400">
        {format(new Date(updatedAt), "dd/MM/yyyy")}
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
