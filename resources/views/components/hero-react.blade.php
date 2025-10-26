<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hero Section - React + Tailwind</title>
    <script src="https://unpkg.com/react@18/umd/react.development.js"></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .font-poppins { font-family: 'Poppins', sans-serif; }
        .font-inter { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body>
    <div id="hero-root"></div>

    <script type="text/babel">
        const { useState, useEffect } = React;

        const HeroSection = () => {
            const [isLoaded, setIsLoaded] = useState(false);

            useEffect(() => {
                setIsLoaded(true);
            }, []);

            const images = [
                {
                    src: "https://source.unsplash.com/featured/?camera",
                    alt: "Camera",
                    className: "w-32 h-40 sm:w-36 sm:h-44 md:w-40 md:h-48 lg:w-44 lg:h-52"
                },
                {
                    src: "https://source.unsplash.com/featured/?headphones",
                    alt: "Headphones",
                    className: "w-32 h-40 sm:w-36 sm:h-44 md:w-40 md:h-48 lg:w-44 lg:h-52"
                },
                {
                    src: "https://source.unsplash.com/featured/?food",
                    alt: "Food",
                    className: "w-36 h-48 sm:w-40 sm:h-52 md:w-44 md:h-56 lg:w-48 lg:h-60" // Larger middle image
                },
                {
                    src: "https://source.unsplash.com/featured/?flowers",
                    alt: "Flowers",
                    className: "w-32 h-40 sm:w-36 sm:h-44 md:w-40 md:h-48 lg:w-44 lg:h-52"
                },
                {
                    src: "https://source.unsplash.com/featured/?airplane,sunset",
                    alt: "Airplane Sunset",
                    className: "w-32 h-40 sm:w-36 sm:h-44 md:w-40 md:h-48 lg:w-44 lg:h-52"
                }
            ];

            return (
                <div className={`min-h-screen bg-white flex items-center justify-center px-4 sm:px-6 lg:px-8 transition-all duration-1000 ${isLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'}`}>
                    <div className="max-w-7xl w-full">
                        <div className="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-center">

                            {/* Left Side - Text and Button */}
                            <div className="space-y-8 text-center lg:text-left">
                                <div className="space-y-6">
                                    <h1 className="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-bold text-gray-800 font-poppins leading-tight">
                                        দূর থেকে লিখি, মনে রাখি কাছের মানুষ আর শহরকে
                                    </h1>

                                    <p className="text-lg sm:text-xl text-gray-500 font-inter max-w-lg mx-auto lg:mx-0">
                                        💫 Let's keep sharing the stories that connect our hearts.
                                    </p>
                                </div>

                                <button className="bg-gray-800 hover:bg-gray-900 text-white px-8 py-4 rounded-full font-semibold text-lg font-inter shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 ease-in-out">
                                    Getting started
                                </button>
                            </div>

                            {/* Right Side - Image Cards */}
                            <div className="flex justify-center lg:justify-end">
                                <div className="flex items-center space-x-2 sm:space-x-3 md:space-x-4 lg:space-x-6">
                                    {images.map((image, index) => (
                                        <div
                                            key={index}
                                            className={`${image.className} rounded-2xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 ease-in-out overflow-hidden group cursor-pointer`}
                                            style={{
                                                transform: `translateY(${index === 2 ? '-8px' : index % 2 === 0 ? '8px' : '-4px'})`,
                                                zIndex: index === 2 ? 10 : 5 - Math.abs(index - 2)
                                            }}
                                        >
                                            <img
                                                src={image.src}
                                                alt={image.alt}
                                                className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                                loading="lazy"
                                            />
                                        </div>
                                    ))}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            );
        };

        // Render the component
        ReactDOM.render(<HeroSection />, document.getElementById('hero-root'));
    </script>
</body>
</html>
