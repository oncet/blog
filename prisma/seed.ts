import { PrismaClient } from "@prisma/client";
import type { Prisma } from "@prisma/client";
import { faker } from "@faker-js/faker";
const prisma = new PrismaClient();

type CategoryWithoutId = Prisma.CategoryGetPayload<{
  select: {
    slug: true;
    name: true;
  };
}>;

type TagWithoutId = Prisma.TagGetPayload<{
  select: {
    slug: true;
    name: true;
  };
}>;

const capitalizeFirstLetter = ([first = "", ...rest]: string) =>
  [first.toUpperCase(), ...rest].join("");

async function main() {
  const categoryData: CategoryWithoutId = {
    slug: "guides",
    name: "Guides",
  };

  const tagsData: TagWithoutId[] = [
    {
      slug: "react",
      name: "React",
    },
    {
      slug: "remix",
      name: "Remix",
    },
  ];

  const imagesUrls = [
    "https://pnhaelxzpnxiuweilmhz.supabase.co/storage/v1/object/public/blog/Pop-Team-Epic-clap.webp",
    "https://pnhaelxzpnxiuweilmhz.supabase.co/storage/v1/object/public/blog/Pop-Team-Epic-explosion.webp",
    "https://pnhaelxzpnxiuweilmhz.supabase.co/storage/v1/object/public/blog/Pop-Team-Epic-hands.webp",
  ];

  for (let i = 0; i < 3; i++) {
    const title = capitalizeFirstLetter(
      faker.helpers.fake("{{word.adverb}} fast")
    );
    const slug = faker.helpers.slugify(title).toLocaleLowerCase();

    const post = await prisma.post.upsert({
      where: { slug: slug },
      update: {},
      create: {
        slug: slug,
        title: title,
        image: imagesUrls[Math.floor(Math.random() * imagesUrls.length)],
        imageAlt: faker.lorem.sentence(),
        body: faker.lorem.sentences(undefined, "\n\n"),
        published: true,
        categories: {
          connectOrCreate: {
            where: { slug: categoryData.slug },
            create: {
              name: categoryData.name,
              slug: categoryData.slug,
            },
          },
        },
        tags: {
          connectOrCreate: tagsData.map((tagData) => ({
            where: { slug: tagData.slug },
            create: { name: tagData.name, slug: tagData.slug },
          })),
        },
      },
    });

    console.log(post);
  }
}

main()
  .then(async () => {
    await prisma.$disconnect();
  })
  .catch(async (e) => {
    console.error(e);
    await prisma.$disconnect();
    process.exit(1);
  });
